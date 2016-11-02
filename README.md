## Synopsis

Configuration parser custom indented config file format (like YAML, python etc.) 

## Code Example

```php
/*...*/
```

```
/*...config sample*/
```

## Motivation

This component is made just to make life better: tabs, dots and commas are more easy to type in. 
Even in Russian keyboard layout or whatever u want.

God bless Hamish Friedlander and [SilverStripe Limited](www.silverstripe.com) for the php-peg parser.
## Installation

composer require lastwhitebird/lgml-parser

## API Reference

```php
use \LWB\LGMLParser\Tree as Tree;
```
To create tree from file:
```php
$tree = Tree::factory('ourfile.lgml');
```

see Code Examples above

## Tests

cd vendor\lastwhitebird\lgml-parser\tests\
php runtest.php

## License

This library is licensed under LGPL v2.1