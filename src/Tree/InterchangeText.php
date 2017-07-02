<?php

namespace LWB\LGMLParser\Tree;

trait InterchangeText 
{

	public function __toString()
	{
		return self::render($this, $this->getOption('line_ending'));
	}

	private static function checkSingleLineness($tree, $le)
	{
		$count = 0;
		foreach ($tree as $element)
		{
			$count++;
			if ($element['@!element'] == '!text' || count($element['@']))
				return false;
			if (count($element) == 0)
				continue;
			if (count($element) > 1 || $element[0]['@!element'] != '!text' || strpos($element[0]['@#text'], $le) !== false)
				return false;
		}
		return $count > 0;
	}

	private static function renderSingleLine($tree, $le, $level)
	{
		$stringify = array_map(function ($element)
		{
			return self::quoteProperly1($element['@!element']) . (count($element) ? ": " . self::quoteProperly2($element[0]['@#text']) : "");
		}, iterator_to_array($tree));
		return array_reduce($stringify, function ($carry, $element) use ($level)
		{
			return (is_null($carry)) ? str_repeat(' ', $level) . $element : $carry . "; " . $element;
		}) . $le;
	}

	private static function render($tree, $le = "\n", $level = 0)
	{
		$result = "";
		foreach ($tree as $element)
		{
			$result .= str_repeat(' ', $level);
			if ($element['@!element'] == '!text')
				$result .= ". " . self::addIndent($level + 2, $element["@#text"]) . $le;
			else
			{
				$result .= self::quoteProperly1($element['@!element']);
				foreach ($element['@'] as $key => $val)
				{
					$result .= ", " . self::quoteProperly1($key) . (is_object($val) ? "" : " " . self::quoteProperly2($val));
				}
				if (count($element) == 1 && $element[0]['@!element'] == '!text')
				{
					$line = $element[0]['@#text'];
					if (strpos($line, $le) === false)
						$append = ". " . $line . $le;
					else
						$append = ": " . $le . self::addIndent($level + 4, $line, true) . $le;
					$result .= $append;
				}
				else
				{
					$result .= $le;
					if (!self::checkSingleLineness($element, $le))
						$result .= self::render($element, $le, $level + 4);
					else
						$result .= self::renderSingleLine($element, $le, $level + 4);
				}
			}
		}
		return $result;
	}
}

