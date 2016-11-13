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
		return Tree::render($this, $this->getOption('line_ending'));
	}

	private static function checkSingleLineness($tree, $le)
	{
		$count = 0;
		foreach ($tree as $element)
		{
			if (count($element) == 0)
				continue;
			if ($element['@!element'] == '!text' || count($element['@']))
				return false;
			if (count($element) > 1 || $element[0]['@!element'] != '!text' || strpos($element[0]['@#text'], $le) !== false)
				return false;
			$count++;
		}
		return $count > 0;
	}

	private static function renderSingleLine($tree, $le, $level)
	{
		$results = [];
		foreach ($tree as $element)
		{
			$result = $element['@!element'];
			if (count($element))
				$result .= ": " . Tree::quoteProperly2($element[0]['@#text']);
			$results[] = $result;
		}
		return str_repeat(' ', $level) . implode("; ", $results) . $le;
	}

	private static function render($tree, $le = "\n", $level = 0)
	{
		$result = "";
		foreach ($tree as $element)
		{
			$result .= str_repeat(' ', $level);
			if ($element['@!element'] == '!text')
				$result .= ". " . Tree::addIndent($level + 2, $element["@#text"]) . $le;
			else
			{
				$result .= $element['@!element'];
				foreach ($element['@'] as $key => $val)
				{
					$result .= ", " . Tree::quoteProperly1($key) . (is_null($val) ? "" : " " . Tree::quoteProperly2($val));
				}
				if (count($element) == 1 && $element[0]['@!element'] == '!text')
				{
					$line = $element[0]['@#text'];
					if (strpos($line, $le) === false)
						$append = ". " . $line . $le;
					else
						$append = ": " . $le . Tree::addIndent($level + 4, $line, true) . $le;
					$result .= $append;
				}
				else
				{
					$result .= $le;
					if (!Tree::checkSingleLineness($element, $le))
						$result .= Tree::render($element, $le, $level + 4);
					else
						$result .= Tree::renderSingleLine($element, $le, $level + 4);
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

	public function toJSON()
	{
		return json_encode($this->tree, JSON_PRETTY_PRINT);
	}
	
	// factory methods
	public function fromJSON($string)
	{
		$this->tree = json_decode($string);
		return $this;
	}

	private static function fileGenerator($filename)
	{
		$handle = fopen($filename, "r");
		if ($handle)
			while (($line = fgets($handle)) !== false)
				yield rtrim($line, "\r\n");
		fclose($handle);
		yield "";
	}

	private static function stringGenerator($string)
	{
		$offset = 0;
		while (preg_match('/.*?(?:\r\n|\n)/', $string, $m, PREG_OFFSET_CAPTURE, $offset))
		{
			$offset = $m[0][1] + strlen($m[0][0]);
			yield rtrim($m[0][0], "\r\n");
		}
		yield "";
	}

	public function fromFile($filename)
	{
		$this->fromString(file_get_contents($filename));
		return $this;
	}

	public static function factoryFromJSON($string, array $options = [])
	{
		$tree_object = new Tree();
		$tree_object->setOptions($options);
		return $tree_object->fromJSON($string);
	}

	public static function factoryFromFile($filename, array $options = [])
	{
		$tree_object = new Tree();
		$tree_object->setOptions($options);
		return $tree_object->fromGenerator(Tree::fileGenerator($filename));
	}

	public static function factoryFromString($string, array $options = [])
	{
		$tree_object = new Tree();
		$tree_object->setOptions($options);
		return $tree_object->fromGenerator(Tree::stringGenerator($string));
	}

	public static function match_Node($line)
	{
		$LGML = new LGML($line);
		return $LGML->match_Node();
	}

	private static function semicolonGenerator($line)
	{
		while ($tree = Tree::match_Node($line))
		{
			yield $tree;
			if (!isset($tree['trailingsemicolon']))
				break;
			$line = substr($line, strlen($tree['text']));
			do
			{
				$exit = true;
				$LGML = new LGML($line);
				if (($text = $LGML->match_Spaces()) && ($len = strlen($text['text'])))
				{
					list($exit, $line) = [
							false, 
							substr($line, $len) 
					];
				}
				while (strlen($line) && ($line[0] == ';'))
				{
					$exit = false;
					$line = substr($line, 1);
				}
			}
			while (!$exit);
			$LGML = new LGML($line);
			if ($LGML->match_OpenCommmentMLine())
			{
				yield false;
			}
		}
	}

	public function fromGenerator($generator)
	{

		function parse_literal($arr)
		{
			if ($arr === null)
				return null;
				// @formatter:off
			if (isset($arr['quoted']))
				return array_key_exists('quotedcontents', $arr['quoted']) ? 
					Tree::unEscapeDoubleQuotes($arr['quoted']['quotedcontents']['text'])
					: 
					Tree::unEscapeSingleQuotes($arr['quoted']['quotedcontents2']['text'])
					;
			// @formatter:on
			return $arr['simple']['text'];
		}
		
		$preparsed = [];
		$dot = false;
		$comment = false;
		// prepare lines
		$le = $this->getOption('line_ending');
		foreach ($generator as $line)
		{
			if ($comment)
			{
				$LGML = new LGML($line);
				if (!$tree = $LGML->match_ClosingCommentMLine())
					continue;
				$len = strlen($tree['text']);
				$line = str_repeat(' ', $len) . substr($line, $len);
				$comment = false;
			}
			list($indent, $line) = $this->normalizeTabs($line);
			
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
							'text' => implode($le, $dot_inner) 
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
			
			foreach (Tree::semicolonGenerator($line) as $tree)
			{
				if (!$tree)
				{
					$comment = true;
					break;
				}
				
				$res = [
						'indent' => $indent, 
						'trailingtext' => @$tree['trailingtext']['text'], 
						'trailingcomma' => @$tree['trailingcomma']['text'], 
						'adefs' => [], 
						'orphandot' => @$tree['orphandot']['text'] 
				];
				
				$adefs = [
						$tree['adef'] 
				];
				$adefs_next = isset($tree['adefs']['adef']) ? (isset($tree['adefs']['adef'][0]) ? $tree['adefs']['adef'] : [
						$tree['adefs']['adef'] 
				]) : [];
				
				$adefs = array_merge($adefs, $adefs_next);
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
					if (!isset($tree['trailingcolontext']))
						list($dot, $dot_inner) = [
								$indent + 2, 
								[] 
						];
					else
						$preparsed[] = [
								'indent' => $indent + 1, 
								'text' => parse_literal($tree['trailingcolontext']) 
						];
				}
			}
		}
		
		// prepare real tree
		$tree = Tree::node('!root');
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
			{
				$current['inner'][] = Tree::textNode($line['trailingtext']);
			}
		}
		$this->tree = $tree;
		return $this;
	}
}
