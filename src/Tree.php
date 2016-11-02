<?php

namespace LWB\LGMLParser;

use \LWB\LGMLParser\LGML as LGML;

class Tree extends Tree\Basic
{

	public function __toString()
	{
		return Tree::render(0, $this);
	}

	private static function quoteright1($string)
	{
		return Tree::quoteright($string, ' "\'"""\'"');
	}

	private static function quoteright2($string)
	{
		return Tree::quoteright($string, ' "\'" "\'"');
	}

	private static function quoteright($string, $code)
	{
		if (strpos($string, ",") !== false)
			$code = str_replace(' ', '"', $code);
		$num = strpos($string, "'") === false ? 0 : 1;
		$num += strpos($string, '"') === false ? 0 : 2;
		$num += strpos($string, ' ') === false ? 0 : 4;
		switch ($code[$num])
		{
			case '"':
				return '"' . str_replace('"', '\\"', $string) . '"';
			case "'":
				return "'" . str_replace("'", "\\'", $string) . "'";
			default:
				return $string;
		}
	}

	private static function render($level = 0, $tree)
	{
		$result = "";
		foreach ($tree as $element)
		{
			if ($element['@!element'] == '!text')
			{
				$text = implode("\n" . str_repeat(' ', $level + 2), explode("\n", $element["@#text"]));
				$result .= str_repeat(' ', $level) . ". " . $text . "\n";
			}
			else
			{
				$result .= str_repeat(' ', $level) . $element['@!element'];
				foreach ($element['@'] as $key => $val)
					$result .= ", " . Tree::quoteright1($key) . " " . Tree::quoteright2($val);
				if (count($element) == 1 && $element[0]['@!element'] == '!text' && strpos($element[0]['@#text'],"\n")===false)
				{
					$result .= ". ".$element[0]['@#text']."\n";
				}
				else
				{
					$result .= "\n";
					$result .= Tree::render($level + 4, $element);
				}
			}
		}
		return $result;
	}
	// factory method
	public static function factory($filename)
	{

		function parse_literal($arr)
		{
			if ($arr === null)
				return 1;
			if (isset($arr['quoted']))
				return array_key_exists('quotedcontents', $arr['quoted']) ? str_replace('\\"', '"', $arr['quoted']['quotedcontents']['text']) : str_replace("\\'", "'", $arr['quoted']['quotedcontents2']['text']);
			return $arr['simple']['text'];
		}
		
		$preparsed = [];
		$dot = false;
		// prepare lines
		foreach (preg_split("/[\r\n]+/", file_get_contents($filename)) as $n => $line)
		{
			if ($dot !== false)
			{
				if (preg_match('/(^\s{' . ($dot + 1) . ',' . ($dot + 2) . '})/', $line, $ext))
				{
					$line = substr($line, strlen($ext[1]));
					$dot_inner[] = $line;
					continue;
				}
				else
				{
					$preparsed[] = [
							'indent' => $dot, 
							'text' => implode("\n", $dot_inner) 
					];
					$dot = false;
				}
			}
			
			$LGML = new LGML($line);
			if ($dot === false && ($tree = $LGML->match_IndentedDot()))
			{
				$dot = strlen($tree['indent']['text']);
				$dot_inner = [
						$tree['trailingtext']['text'] 
				];
				continue;
			}
			
			$LGML = new LGML($line);
			if (!$tree = $LGML->match_Node())
				continue;
			
			$res = [
					'indent' => strlen($tree['indent']['text']), 
					'trailingtext' => @$tree['trailingtext']['text'], 
					'trailingcolon' => @$tree['trailingcolon']['text'], 
					'adefs' => [], 
					'orphandot' => @$tree['orphandot']['text'] 
			];
			$adefs = isset($tree['adef'][0]) ? $tree['adef'] : [
					$tree['adef'] 
			];
			foreach ($adefs as $adef)
			{
				$res['adefs'][] = [
						parse_literal($adef['first']), 
						parse_literal(@$adef['second']) 
				];
			}
			$preparsed[] = $res;
		}
		
		// var_dump($preparsed);die();
		// prepare real tree
		$tree = [
				'element' => '!root', 
				'attributes' => [], 
				'inner' => [] 
		];
		$indents = [
				-1 => &$tree 
		];
		$awaiting_atts = false;
		$current = &$tree;
		
		foreach ($preparsed as $n => $line)
		{
			$is_text = isset($line['text']);
			if (!$awaiting_atts || $is_text)
			{
				$i = $line['indent'];
				foreach (array_keys($indents) as $k)
					if ($k >= $i)
						unset($indents[$k]);
				$last = max(array_keys($indents));
				$current = &$indents[$last];
				
				if ($is_text)
				{
					$node = [
							'element' => '!text', 
							'attributes' => [
									'#text' => $line['text'] 
							], 
							'inner' => [] 
					];
				}
				else
				{
					$el = array_shift($line['adefs']);
					$node = [
							'element' => $el[0], 
							'attributes' => [], 
							'inner' => [] 
					];
					foreach ($line['adefs'] as $adef)
						$node['attributes'][$adef[0]] = $adef[1];
				}
				$current['inner'][] = $node;
				$indents[$i] = &$current['inner'][count($current['inner']) - 1];
				$current = &$current['inner'][count($current['inner']) - 1];
			}
			else
			{
				$last = max(array_keys($indents));
				$current = &$indents[$last];
				foreach ($line['adefs'] as $adef)
					$current['attributes'][$adef[0]] = $adef[1];
			}
			
			$awaiting_atts = isset($line['trailingcolon']) && !isset($line['trailingtext']);
			
			if (isset($line['trailingtext']))
				$current['inner'][] = [
						'element' => '!text', 
						'attributes' => [
								'#text' => $line['trailingtext'] 
						], 
						'inner' => [] 
				];
		}
		return new Tree($tree);
	}
}
