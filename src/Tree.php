<?php

namespace LWB\LGMLParser;

use \LWB\LGMLParser\LGML as LGML;

class Tree extends Tree\Configurable
{
	use Tree\Quotes;

	public static function textNode($text)
	{
		return [
				'element' => '!text', 
				'attributes' => [
						'#text' => $text 
				], 
				'inner' => [] 
		];
	}

	public static function node($element, $attributes = [])
	{
		return [
				'element' => $element, 
				'attributes' => $attributes, 
				'inner' => [] 
		];
	}
	
	// serialize methods
	public function __toString()
	{
		return Tree::render(0, $this);
	}

	private static function render($level = 0, $tree)
	{
		$result = "";
		foreach ($tree as $element)
		{
			if ($element['@!element'] == '!text')
				$result .= str_repeat(' ', $level).". " . Tree::addIndent($level + 2, $element["@#text"]) . "\n";
			else
			{
				$result .= str_repeat(' ', $level) . $element['@!element'];
				foreach ($element['@'] as $key => $val)
				{
					$result .= ", " . Tree::quoteright1($key) . (is_null($val) ? "" : " " . Tree::quoteright2($val));
				}
				if (count($element) == 1 && $element[0]['@!element'] == '!text')
				{
					$line = $element[0]['@#text'];
					if (strpos($line, "\n") === false)
						$append = ". " . $line . "\n";
					else
						$append = ": \n" . Tree::addIndent($level + 4, $line, true) . "\n";
					$result .= $append;
				}
				else
					$result .= "\n" . Tree::render($level + 4, $element);
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

	public function toJSON()
	{
		return json_encode($this->tree, JSON_PRETTY_PRINT);
	}
	
	// factory methods
	public static function factoryFromJSON($string)
	{
		$tree_object = new Tree();
		$tree_object->tree = json_decode($string);
		return $tree_object;
	}

	public static function factoryFromFile($filename)
	{
		return Tree::factoryFromString(file_get_contents($filename));
	}

	public static function factoryFromString($string)
	{
		$tree_object = new Tree();

		function parse_literal($arr)
		{
			if ($arr === null)
				return null;
			// @formatter:off
			if (isset($arr['quoted']))
				return array_key_exists('quotedcontents', $arr['quoted']) ? 
					Tree::unEscape1($arr['quoted']['quotedcontents']['text'])
					: 
					Tree::unEscape2($arr['quoted']['quotedcontents2']['text'])
					;
			// @formatter:on
			return $arr['simple']['text'];
		}
		
		$preparsed = [];
		$dot = false;
		$comment = false;
		// prepare lines
		foreach (preg_split("/[\r\n]+/", $string) as $line)
		{
			if ($comment)
			{
				$LGML = new LGML($line);
				$tree = $LGML->match_ClosingComment();
				if (!$tree)
					continue;
				$len = strlen($tree['text']);
				$line = str_repeat(' ', $len) . substr($line, $len);
				$comment = false;
			}
			list($indent, $line) = $tree_object->normalizeTabs($line);
			
			if ($dot !== false)
			{
				// var_dump($dot,$indent,$line);
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
					// var_dump($dot,$dot_inner,$line);
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
					'indent' => $indent, 
					'trailingtext' => @$tree['trailingtext']['text'], 
					'trailingcomma' => @$tree['trailingcomma']['text'], 
					'adefs' => [], 
					'orphandot' => @$tree['orphandot']['text'] 
			];
			$adefs = isset($tree['adef'][0]) ? $tree['adef'] : [
					$tree['adef'] 
			];
			
			foreach ($adefs as $adef)
				if (isset($adef['tc']['lm']))
				{
					$comment = true;
				}
			
			foreach ($adefs as $adef)
			{
				$res['adefs'][] = [
						parse_literal($adef['first']), 
						parse_literal(@$adef['second']) 
				];
			}
			$preparsed[] = $res;
			if (isset($tree['trailingcolon']))
			{
				$dot = $indent + 2;
				$dot_inner = [];
			}
		}
		
		// var_dump($preparsed);die();
		// prepare real tree
		$tree = Tree::node('!root');
		$indents = [
				-1 => &$tree 
		];
		$awaiting_atts = false;
		$current = &$tree;
		
		foreach ($preparsed as $n => $line)
		{
			// var_dump($line);
			$is_text = isset($line['text']);
			if (!$awaiting_atts || $is_text)
			{
				$i = $line['indent'];
				$indents = array_filter($indents, function ($v) use ($i)
				{
					return ($v < $i);
				}, ARRAY_FILTER_USE_KEY);
				$last = max(array_keys($indents));
				$current = &$indents[$last];
				
				if ($is_text)
				{
					$node = Tree::textNode($line['text']);
				}
				else
				{
					$el = array_shift($line['adefs']);
					$node = Tree::node($el[0]);
					foreach ($line['adefs'] as $adef)
						$node['attributes'][$adef[0]] = $adef[1];
				}
				$current['inner'][] = $node;
				$indents[$i] = &$current['inner'][count($current['inner']) - 1];
				$current = &$current['inner'][count($current['inner']) - 1];
			}
			else
			{
				foreach ($line['adefs'] as $adef)
					$current['attributes'][$adef[0]] = $adef[1];
			}
			
			$awaiting_atts = isset($line['trailingcomma']) && !isset($line['trailingtext']);
			
			if (isset($line['trailingtext']))
				$current['inner'][] = Tree::textNode($line['trailingtext']);
		}
		$tree_object->tree = $tree;
		return $tree_object;
	}
}
