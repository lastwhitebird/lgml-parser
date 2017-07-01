<?php

namespace LWB\LGMLParser\Tree;

trait InterchangeXML 
{

	private static function xml_traverse($node, &$tree)
	{
		// var_dump($node->nodeType );
		switch ($node->nodeType)
		{
			case XML_CDATA_SECTION_NODE:
			case XML_TEXT_NODE:
				// $text = trim($node->textContent);
				$text = $node->textContent;
				if (trim($node->textContent))
				{
					$tree['inner'][] = self::textNode($text);
					// var_dump($tree);
				}
				break;
			case XML_ELEMENT_NODE:
			case XML_DOCUMENT_NODE:
				if ($node->nodeType == XML_ELEMENT_NODE)
					$tree['element'] = $node->tagName;
				if ($node->childNodes)
					for ($i = 0, $m = $node->childNodes->length; $i < $m; $i++)
					{
						$childnode = $node->childNodes->item($i);
						$nodestub = self::node('');
						self::xml_traverse($childnode, $nodestub);
						if (!$nodestub['element'])
							self::xml_traverse($childnode, $tree);
						else
							$tree['inner'][] = $nodestub;
					}
				if ($node->attributes && $node->attributes->length)
				{
					foreach ($node->attributes as $attrName => $attrNode)
					{
						$tree['attributes'][($attrNode->prefix ? $attrNode->prefix . ":" : "") . $attrName] = (string) $attrNode->value;
					}
				}
				break;
		}
	}

	public function fromXML($filename)
	{
		$nodes = [];
		$XMLDecl = null;

		function extract_xmldecl($string)
		{
			preg_match('/(<\?.*?\?>)/ism', $string, $ext);
			return isset($ext[1]) ? $ext[1] : "";
		}
		
		$string = file_get_contents($filename);
		do
		{
			$again = false;
			$tree = self::node('');
			$doc = new \DOMDocument();
			try
			{
				$doc->loadXML($string);
			}
			catch (\ErrorException $e)
			{
				$err_msg = $e->getMessage();
				if (preg_match('/DOMDocument::loadXML\(\): Extra content at the end of the document in Entity, line: (\d+)/', $err_msg, $ext))
				{
					$err_line = $ext[1];
					preg_match('/(?:.*?\n){' . ($err_line - 1) . '}/ism', $string, $ext);
					$cut = strlen($ext[0]);
					$temp_string = (!is_null($XMLDecl) ? $XMLDecl : "") . $ext[0];
					//var_dump($temp_string);
					$doc->loadXML($temp_string);
					$XMLDecl = !is_null($XMLDecl) ? $XMLDecl : extract_xmldecl($string);
					$again = true;
					$string = substr($string, $cut);
				}
			}
			self::xml_traverse($doc->documentElement, $tree);
			$nodes[] = $tree;
		} while ($again);
		$result = self::node('', [], $nodes);
		// var_dump($result);
		return self::factoryFromTree($result);
	}

	public function toXML($quote_function = false, $quote_attribute_function = false)
	{
		$writer = new \XMLWriter();
		$writer->openMemory();
		if ($this->getOption('pretty_print'))
			$writer->setIndentString("    ");
		$writer->setIndent(true);
		$writer->startDocument('1.0', 'UTF-8', 'yes');
		self::renderXML($writer, $this, $quote_function, $quote_attribute_function);
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
				// var_dump($elname);
				if ($quote_function)
					$elname = $quote_function($elname);
				try
				{
					$writer->startElement($elname);
				}
				catch (\Exception $e)
				{
					echo "element failed: $elname\n";
					die();
				}
				foreach ($element['@'] as $key => $val)
				{
					if ($quote_attribute_function)
						$key = $quote_attribute_function($key);
					$writer->writeAttribute($key, is_object($val) ? $key : $val);
				}
				self::renderXML($writer, $element, $quote_function, $quote_attribute_function);
				$writer->endElement();
			}
		}
	}
}