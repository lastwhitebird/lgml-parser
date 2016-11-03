<?php

namespace LWB\LGMLParser;

use \LWB\LGMLParser\LGML as LGML;

class Tree extends Tree\Basic
{
	private $_tabs;

	function getTabs()
	{
		return $this->_tabs;
	}

	function setTabs($newvalue)
	{
		$this->_tabs = $newvalue;
	}

	static function normalizeTabs($string)
	{
		$count = 0;
		$chars = 0;
		for ($i = 0; $i < strlen($string); $i++, $chars++)
		{
			if ($string[$i] == "\t")
				$count = (floor($count / 4) + 1) * 4;
			else 
				if ($string[$i] == " ")
					$count++;
				else
					break;
		}
		return [
				$count, 
				substr($string, $chars) 
		];
	}
	
	// serialize methods
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
					$result .= ", " . Tree::quoteright1($key) . (is_null($val) ? "" : " " . Tree::quoteright2($val));
				if (count($element) == 1 && $element[0]['@!element'] == '!text' && strpos($element[0]['@#text'], "\n") === false)
				{
					$result .= ". " . $element[0]['@#text'] . "\n";
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

	public function toXML($filename, $quote_function = false, $quote_attribute_function = false)
	{
		$writer = new \XMLWriter();
		$writer->openMemory();
		$writer->setIndentString("    ");
		$writer->setIndent(true);
		$writer->startDocument('1.0', 'UTF-8', 'yes');
		Tree::renderXML($writer, $this, $quote_function, $quote_attribute_function);
		$writer->endDocument();
		return $writer->outputMemory();
	}

	private static function renderXML($writer, $tree, $quote_function = false, $quote_attribute_function = false)
	{
		foreach ($tree as $element)
		{
			if ($element['@!element'] == '!text')
				$writer->text($element["@#text"]);
			else
			{
				$elname = $element['@!element'];
				if ($quote_function)
					$elname = $quote_function($elname);
				$writer->startElement($elname);
				foreach ($element['@'] as $key => $val)
				{
					if ($quote_attribute_function)
						$key = $quote_attribute_function($key);
					$writer->writeAttribute($key, is_null($val) ? $key : $val);
				}
				Tree::renderXML($writer, $element, $quote_function, $quote_attribute_function);
				$writer->endElement();
			}
		}
	}

	public static function toJSON($string)
	{
		return json_encode($this->tree);
	}
	
	// factory methods
	public static function factoryFromJSON($string)
	{
		return new Tree(json_decode($string));
	}

	public static function factoryFromFile($filename)
	{
		return Tree::factoryFromString(file_get_contents($filename));
	}

	public static function factoryFromString($string)
	{

		function parse_literal($arr)
		{
			if ($arr === null)
				return null;
			if (isset($arr['quoted']))
				return array_key_exists('quotedcontents', $arr['quoted']) ? str_replace('\\"', '"', $arr['quoted']['quotedcontents']['text']) : str_replace("\\'", "'", $arr['quoted']['quotedcontents2']['text']);
			return $arr['simple']['text'];
		}
		
		$preparsed = [];
		$dot = false;
		// prepare lines
		foreach (preg_split("/[\r\n]+/", $string) as $line)
		{
			list($indent, $line) = Tree::normalizeTabs($line);
			
			if ($dot !== false)
			{
				if ($indent > $dot + 1)
				{
					$line = str_repeat(' ', $indent - $dot - 2) . $line;
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
				$dot = $indent;
				$dot_inner = [
						$tree['trailingtext']['text'] 
				];
				continue;
			}
			
			$LGML = new LGML($line);
			if (!$tree = $LGML->match_Node())
				continue;
			
			$res = [
					'indent' =>  $indent, 
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
