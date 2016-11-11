<?php

namespace LWB\LGMLParser\Tree;

class Configurable extends Basic
{
	public $options = [
			'tabs' => 4,
			'line_ending' => "\n"
	];

	public function __construct(array $options = [])
	{
		$this->setOptions($options);
		parent::__construct();
	}

	public function setOptions(array $options)
	{
		$this->options = $options + $this->options;
		return $this;
	}

	public function setOption($name, $value)
	{
		$this->options[$name] = $value;
		return $this;
	}

	public function getOption($name)
	{
		return @$this->options[$name];
	}
}