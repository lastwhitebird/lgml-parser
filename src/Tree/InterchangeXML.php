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
					foreach ($node->attributes as $attrName => $attrNode)
						$tree['attributes'][($attrNode->prefix ? $attrNode->prefix . ":" : "") . $attrName] = (string) $attrNode->value;
				break;
		}
	}

	private static function extract_xmldecl($string, $doc, &$nodes)
	{
		preg_match('/(<\?.*?\?>)/ism', $string, $ext);
		if (isset($ext[1]))
		{
			$tree = self::node('?xml', [
					'version' => $doc->xmlVersion,
					'encoding' => $doc->encoding,
					'standalone' => $doc->xmlStandalone ? 'yes' : 'no'
			]);
			$nodes[] = $tree;
		}
		return isset($ext[1]) ? $ext[1] : "";
	}

	public function fromXML($filename)
	{
		$nodes = [];
		$XMLDecl = null;
		
		$string = file_get_contents($filename);
		do
		{
			$tree = self::node('');
			$doc = new \DOMDocument();
			try
			{
				$doc->loadXML($string);
				self::extract_xmldecl($string, $doc, $nodes);
				$string = false;
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
					// var_dump($temp_string);
					$doc->loadXML($temp_string);
					$XMLDecl = !is_null($XMLDecl) ? $XMLDecl : self::extract_xmldecl($string, $doc, $nodes);
					$string = substr($string, $cut);
				}
			}
			self::xml_traverse($doc->documentElement, $tree);
			$xpath = new \DOMXPath($doc);
			$context = $doc->documentElement;
			foreach ($xpath->query('namespace::*', $context) as $node)
				$tree['attributes'][$node->nodeName] = (string) $node->nodeValue;
			$nodes[] = $tree;
		} while ($string);
		$result = self::node('', [], $nodes);
		// var_dump($result);
		return self::factoryFromTree($result);
	}

	public function toXML($quote_function = false, $quote_attribute_function = false)
	{
		$writer = new \XMLWriter();
		$writer->openMemory();
		// Option: pretty_print
		if ($this->getOption('pretty_print'))
		{
			$writer->setIndentString("    ");
			$writer->setIndent(true);
		}
		// Header
		if (isset($this['?xml'][0]))
			$writer->startDocument($this['?xml'][0]['@version'], $this['?xml'][0]['@encoding'], $this['?xml'][0]['@standalone']);
		// TODO: !DOCTYPE
		// Rendering
		self::renderXML($writer, $this, $quote_function, $quote_attribute_function);
		$writer->endDocument();
		return $writer->outputMemory();
	}

	private static function renderXML($writer, $tree, $quote_function = false, $quote_attribute_function = false)
	{
		foreach ($tree as $element)
		{
			if ($element['@!element'] == '?xml')
				continue;
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