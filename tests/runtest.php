<?php
use \LWB\LGMLParser\Tree as Tree;

$a_dir = getcwd();
for ($i = 0; $i < 3; $i++)
	$a_dir = dirname($a_dir);
include $a_dir . '/autoload.php';

$tree = Tree::factoryFromFile(getcwd() . '/testfile.lgml');
$inner_text = function ($node)
{
	return $node['inner'][0]['attributes']['#text'];
};

if (0)
	$tree->walk(function (&$element, &$parent) use ($inner_text)
	{
		if ($element['element'] == '#include')
		{
			$filename = $inner_text($element);
			$tree = Tree::factoryFromFile(getcwd() . '/' . $filename);
			$nodes = $tree->tree['inner'];
			$key = array_search($element, $parent['inner']);
			array_splice($parent['inner'], $key, 1, $nodes);
		}
	});
// basic element tests
assert($tree['element'][0], 'element existence failed!');
assert($tree['element'][999] !== false, 'element non-existence failed!');
assert($tree['element'][0]['@!element'] === 'element', 'element name failed!');
assert(count($tree['element']) == 2, 'element count failed!');

// attribute tests
assert(isset($tree['element-a'][0]['@attribute']), 'element attribute existence failed!');
assert($tree['element-a'][1]['@attribute'] == $tree['element-a'][0]['@attribute'], 'element attribute value failed!');
assert($tree['element-a'][3]['@attribute'] == $tree['element-a'][2]['@attribute'], 'element attribute value failed!');

// text nodes
assert($tree['element'][1]['!text'][0], 'text node existence failed!');
assert(!isset($tree['element'][0]['!text'][0]), 'text node non-existence failed!');
assert($tree['element-t'][0]['!text'][0]['@#text'] === $tree['element-t'][1]['!text'][0]['@#text'], 'textnode w/semicolon test failed!');

echo $tree->__toString();