<?php

namespace LWB\LGMLParser\Tree;

trait Quotes
{

	public static function unEscapeDoubleQuotes($string)
	{
		return preg_replace('/\\\\([\\\\"\\\\])/', '\\1', $string);
	}

	public static function unEscapeSingleQuotes($string)
	{
		return preg_replace('/\\\\([\\\'\\\\])/', '\\1', $string);
	}

	public static function quoteProperly1($string)
	{
		return call_user_func([
				__CLASS__,
				'quoteProperly' 
		], $string, ' "\'"""\'"');
	}

	public static function quoteProperly2($string)
	{
		return call_user_func([
				__CLASS__,
				'quoteProperly' 
		], $string, ' "\'" "\'"');
	}

	private static function quoteProperly($string, $code)
	{
		if (!strlen($string))
			return '""';
		$forbidden = [
				'.',
				',',
				':',
				';',
				'//',
				'/*',
				'*/' 
		];
		$occurences = array_map(function ($item) use ($string)
		{
			return strpos($string, $item) !== false;
		}, $forbidden);
		$occurence_met = array_reduce($occurences, function ($carry, $item)
		{
			return $carry || $item;
		}, false);
		$num = $occurence_met ? 1 : 0;
		$num |= strpos($string, "'") === false ? 0 : 1;
		$num |= strpos($string, '"') === false ? 0 : 2;
		$num |= strpos($string, ' ') === false ? 0 : 4;
		switch ($code[$num])
		{
			case '"':
				return '"' . preg_replace('/(["\\\\])/', '\\\\$1', $string) . '"';
			case "'":
				return "'" . preg_replace('/([\'\\\\])/', '\\\\$1', $string) . "'";
			default:
				return $string;
		}
	}

	public static function addIndent($level, $string, $first = false)
	{
		if ($first === true)
			$first = $level;
		return ($first ? str_repeat(' ', $first) : "") . implode("\n" . str_repeat(' ', $level), explode("\n", $string));
	}

	public function normalizeTabs($string)
	{
		$count = 0;
		$chars = 0;
		$tabs = $this->options['tabs'];
		for ($i = 0; $i < strlen($string); $i++, $chars++)
		{
			if ($string[$i] == "\t")
				$count = (floor($count / $tabs) + 1) * $tabs;
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
}
