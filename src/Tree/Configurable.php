<?php

namespace LWB\LGMLParser\Tree;

class Configurable extends Basic
{
	public $options = [
			'tabs' => 4, 
			'line_ending' => "\n" 
	];
	private $options_tack = [];

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

	public function saveOptions()
	{
		$this->options_stack[] = $this->options;
		return $this;
	}

	public function restoreOptions()
	{
		if ($options = array_pop($this->options_stack))
			$this->options = $options;
	}
}
