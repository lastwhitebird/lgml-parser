## Synopsis

Configuration parser custom indented config file format (like YAML, python etc.) 

## Code Example

PHP:
```php
		use \LWB\LGMLParser\Tree as Tree;
		$tree = Tree::factoryFromFile('tree.lgml');
		//serialization
		file_put_contents('tree.json', $tree->toJSON());
		//accessing tree nodes
		if (isset($tree['domains'][0]))
		foreach ($tree['domains'][0] as $domain)
			$domains[$domain['@!element']] = $domain['@'];
```

tree.lgml
```
/*...config sample*/
domains
      year, type dateTime, 
      		validator "digits_between:4,4"
      date, type dateTime
tables
  admin_rights, timestamps, softdeletes,
   section "user"
    columns
      key, type string, title "Key (in the form of: latin_letters)"
      name, type string,  title "Readable name"
    rows
      row
       key. process_complain_cancel
       name. Processing cancelling payment on customer complain
    
```

and more!

## Motivation

This component is made just to make life better: tabs, dots and commas are more easy to type in. 
Even in Russian keyboard layout or whatever u want.

God bless Hamish Friedlander and [SilverStripe Limited](www.silverstripe.com) for the php-peg parser.
## Installation

composer require lastwhitebird/lgml-parser

## API Reference

The main class:
```php
namespace LWB\LGMLParser;
class Tree
{
	use Tree\Quotes;
	/* 2 helper methods. dunno, they must be in the Basic class probably */
	public static function textNode($text);
	public static function node($element, $attributes = [])
	/* serialize methods */
	public function __toString()
	public function toXML($filename, $quote_function = false, $quote_attribute_function = false)
	public function toJSON()
	/* factory methods */
	public static function factoryFromJSON($string, array $options = [])
	public static function factoryFromFile($filename, array $options = [])
	public static function factoryFromString($string, array $options = [])
	public function fromJSON($string)
	public function fromFile($filename)
	/* the basic "read" method. You may use it with the generator yielding each line with no \r\n-s 
	 * (working with sockets or whatever
	 */
	public function fromGenerator($generator)

```

Parent class:
```php
namespace LWB\LGMLParser\Tree;
class Configurable extends Basic
{
	/* yes, it's public. you may use it directly */
	public $options;
	/* all the method are self-documenting */
	public function __construct(array $options = []) {}
	public function setOption($name, $value) {}
	/* this 2 methods return $this */
	public function setOptions(array $options) {}
	public function getOption($name) {}
}
```

Helper functions:
```php
namespace LWB\LGMLParser\Tree;
trait Quotes
{
	/* this un-escapes \" and \\ */
	public static function unEscapeDoubleQuotes($string) {}
	/* this un-escapes \' and \\ */
	public static function unEscapeSingleQuotes($string) {}
	/*this surrounds with proper quotes pair the 1st argument in k=>v pair of the 
 	 * markup language, i.e. element's or attribute's name if needed
	 */
	public static function quoteProperly1($string) {}
	/* this surrounds with proper quotes pair the 2nd argument in k=>v pair of the 
 	 * markup language, i.e. attribute's value if needed
	 */
	public static function quoteProperly2($string) {}
	/* adds indentation ($level spaces) to each every-but-1st line of the multiline string. 
	 * if $first===true adds the same spaces to the 1st line.
	 * or $first*spaces if $first is not false
	 */
	public static function addIndent($level, $string, $first = false) {}
	/* converts tabs to spaces (by default tab=4*space. use ->setOption('tabs') method 
	 * to overrride
	 */
	private function normalizeTabs($string) {}
}
```

Basic class. Implements \Iterator, \ArrayAccess, \Countable
```php
namespace LWB\LGMLParser\Tree;
class Basic 
{
	/* the tree data structure itself */
	public $tree = null;
	/* this allows us to iterate only certain kind of nodes, i.e. "table" */
	public $filter = false;
	/* "factory" method */
	public static function factoryFromTree(array &$tree, $filter = false) {}
	/* Iterating in foreach operator section */
	function rewind() {}
	function current() {}
	function key() {}
	function next() {}
	function valid() {}
	/* this allows us to get count($tree_instance) */
	public function count() {}
	/* check if tree_as_array's offset exists e.g.: isset($tree_object['table']) */
	public function offsetExists($offset) {}
	/* treating tree as array e.g.: $tree_object['table'][0] */
	public function offsetGet($offset) {}
}
```

## Tests

cd vendor\lastwhitebird\lgml-parser\tests\
php runtest.php

## License

This library is licensed under LGPL v2.1