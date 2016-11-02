<?php

namespace LWB\LGMLParser;

use \LWB\LGMLParser\LGML as LGML;

class Tree extends Tree\Basic
{
	// factory method
	public static function factory($filename)
	{

		function parse_literal($arr)
		{
			if ($arr === null)
				return 1;
			if (isset($arr['quoted']))
				return array_key_exists('quotedcontents', $arr['quoted']) ? $arr['quoted']['quotedcontents']['text'] : $arr['quoted']['quotedcontents2']['text'];
			return $arr['simple']['text'];
		}
		
		$preparsed = [];
		$dot = false;
		$dot_inner = [];
		// prepare lines
		foreach (preg_split("/[\r\n]+/", file_get_contents($filename)) as $n => $line)
		{
			if ($dot)
			{
				preg_match('/(\s*).*/', $line, $ext);
				if (strlen($ext[1]) <= $dot)
				{
					$last1 = &$preparsed[count($preparsed) - 1];
					$last1['trailingtext'] = implode("\n", $dot_inner);
					$dot = false;
					$dot_inner = [];
				}
				else
				{
					$dot_inner[] = $line;
					continue;
				}
			}
			
			$LGML = new LGML($line);
			
			if (!$dot && $LGML->match_IndentedDot())
			{
				$dot = strlen($tree['indent']['text']);
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
			if ($awaiting_atts)
			{
				$last = max(array_keys($indents));
				$current = &$indents[$last];
				foreach ($line['adefs'] as $adef)
					$current['attributes'][$adef[0]] = $adef[1];
			}
			else
			{
				$i = $line['indent'];
				foreach (array_keys($indents) as $k)
					if ($k >= $i)
						unset($indents[$k]);
				if (!count($indents))
					dd($line);
				$last = max(array_keys($indents));
				$current = &$indents[$last];
				
				$el = array_shift($line['adefs']);
				$node = [
						'element' => $el[0], 
						'attributes' => [], 
						'inner' => [] 
				];
				foreach ($line['adefs'] as $adef)
					$node['attributes'][$adef[0]] = $adef[1];
				$current['inner'][] = $node;
				$indents[$i] = &$current['inner'][count($current['inner']) - 1];
				$current = &$current['inner'][count($current['inner']) - 1];
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
