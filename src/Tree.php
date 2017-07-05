<?php

namespace LWB\LGMLParser;

use \LWB\LGMLParser\LGML as LGML;

class Tree extends Tree\Configurable
{
	use Tree\Quotes;
	use Tree\InterchangeXML;
	use Tree\InterchangeText;

	// serialize methods
	public function toJSON()
	{
		$flags = 0;
		$flags |= $this->getOption('pretty_print') ? JSON_PRETTY_PRINT : 0;
		return json_encode($this->tree, $flags);
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

	public static function factoryFromXML($string, array $options = [])
	{
		$tree_object = new Tree();
		$tree_object->saveOptions()->setOptions($options);
		$return = $tree_object->fromXML($string);
		$tree_object->restoreOptions();
		return $return;
	}

	public static function factoryFromJSON($string, array $options = [])
	{
		$tree_object = new Tree();
		$tree_object->saveOptions()->setOptions($options);
		$return = $tree_object->fromJSON($string);
		$tree_object->restoreOptions();
		return $return;
	}

	public static function factoryFromFile($filename, array $options = [])
	{
		$tree_object = new Tree();
		$tree_object->saveOptions()->setOptions($options);
		$return = $tree_object->fromGenerator(self::fileGenerator($filename));
		$tree_object->restoreOptions();
		return $return;
	}

	public static function factoryFromString($string, array $options = [])
	{
		$tree_object = new Tree();
		$tree_object->saveOptions()->setOptions($options);
		$return = $tree_object->fromGenerator(self::stringGenerator($string));
		$tree_object->restoreOptions();
		return $return;
	}

	public static function match_Node($line)
	{
		$LGML = new LGML($line);
		return $LGML->match_Node();
	}

	private static function semicolonGenerator($line)
	{
		$LGML = new LGML($line);
		if ($LGML->match_OpenCommmentMLine())
		{
			yield false;
			return;
		}
		while ($tree = self::match_Node($line))
		{
			yield $tree;
			$line = substr($line, strlen($tree['text']));
			if (!isset($tree['trailingsemicolon']))
				break;
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
			} while (!$exit);
			$LGML = new LGML($line);
			if ($LGML->match_OpenCommmentMLine())
			{
				yield false;
				return;
			}
		}
	}

	public static function parse_literal($arr)
	{
		if ($arr === null)
			return null;
		// @formatter:off
			if (isset($arr['quoted']))
				return array_key_exists('quotedcontents', $arr['quoted']) ?
				self::unEscapeDoubleQuotes($arr['quoted']['quotedcontents']['text'])
				:
				self::unEscapeSingleQuotes($arr['quoted']['quotedcontents2']['text'])
				;
		// @formatter:on
		return $arr['simple']['text'];
	}

	public function fromGenerator($generator)
	{
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
			
			foreach (self::semicolonGenerator($line) as $tree)
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
							self::parse_literal($adef['first']),
							self::parse_literal(@$adef['second']) 
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
								'text' => self::parse_literal($tree['trailingcolontext']) 
						];
				}
			}
		}
		
		// prepare real tree
		$tree = self::node('!root');
		$indents = [
				-1 => &$tree 
		];
		$awaiting_atts = false;
		$current = &$tree;

		function push_attributes(&$atts, $adefs)
		{
			if (!isset($adefs[1]))
				$adefs[1] = new \stdClass();
			$atts[$adefs[0]] = $adefs[1];
		}
		
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
					$node = self::textNode($line['text']);
				}
				else
				{
					$el = array_shift($line['adefs']);
					$node = self::node($el[0]);
					foreach ($line['adefs'] as $adef)
						push_attributes($node['attributes'], $adef);
				}
				$current['inner'][] = $node;
				$indents[$i] = &$current['inner'][count($current['inner']) - 1];
				$current = &$current['inner'][count($current['inner']) - 1];
			}
			else
			{
				foreach ($line['adefs'] as $adef)
					push_attributes($current['attributes'], $adef);
			}
			
			$awaiting_atts = isset($line['trailingcomma']) && !isset($line['trailingtext']);
			
			if (isset($line['trailingtext']))
			{
				$current['inner'][] = self::textNode($line['trailingtext']);
			}
		}
		$this->tree = $tree;
		return $this;
	}
}
