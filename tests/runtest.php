<?php
use \LWB\LGMLParser\Tree as Tree;

$a_dir = getcwd();
for ($i = 0; $i < 3; $i++)
	$a_dir = dirname($a_dir);
include $a_dir . '/autoload.php';

$tree = Tree::factory(getcwd() . '/testfile.lgml');
var_dump($tree);

assert($tree['element'][0], 'element existence failed!');
assert($tree['element'][999] !== false, 'element non-existence failed!');
assert($tree['element'][0]['@!element'] === 'element', 'element name failed!');
assert(count($tree['element']) == 2, 'element count failed!');
