<?php

namespace LWB\LGMLParser\Tree;

class Configurable extends Basic
{
	public $options = [
			'tabs' => 4 
	];

	public function __construct($options = [])
	{
		$this->options = $this->options + $options;
		parent::__construct();
	}
}