<?php

namespace LWB\LGMLParser\Tree;

class Configurable extends Basic
{
	public $options = [
			'tabs' => 4 
	];

	public function __construct($options = [])
	{
		$this->options = $options + $this->options;
		parent::__construct();
	}
}