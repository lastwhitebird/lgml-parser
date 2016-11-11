<?php

namespace LWB\LGMLParser\Tree;

trait Quotes
{

	public static function unEscape1($str)
	{
		return preg_replace('/\\\\([\\\\"\\\\])/', '\\1', $str);
	}

	public static function unEscape2($str)
	{
		return preg_replace('/\\\\([\\\'\\\\])/', '\\1', $str);
	}

	private static function quoteright1($string)
	{
		return call_user_func([
				__CLASS__, 
				'quoteright' 
		], $string, ' "\'"""\'"');
	}

	private static function quoteright2($string)
	{
		return call_user_func([
				__CLASS__, 
				'quoteright' 
		], $string, ' "\'" "\'"');
	}

	private static function quoteright($string, $code)
	{
		if (strpbrk($string, ",.:") !== false)
			$code = str_replace(' ', '"', $code);
		if (!strlen($string))
			return '""';
		$num = strpos($string, "'") === false ? 0 : 1;
		$num += strpos($string, '"') === false ? 0 : 2;
		$num += strpos($string, ' ') === false ? 0 : 4;
		$re1 = '/\\\\([\\\\"\\\\])/';
		$re2 = '/\\\\([\\\'\\\\])/';
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

	private static function addIndent($level, $string, $first = false)
	{
		if ($first === true)
			$first = $level;
		return ($first ? str_repeat(' ', $first) : "") . implode("\n" . str_repeat(' ', $level), explode("\n", $string));
	}

	private function normalizeTabs($string)
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
