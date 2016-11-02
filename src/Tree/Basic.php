<?php

namespace LWB\LGMLParser\Tree;

use \LWB\LGMLParser\LGML as LGML;

class Basic implements \Iterator, \ArrayAccess, \Countable
{
	var $tree = null;
	var $filter = false;
	var $position = 0;
	var $real = 0;

	public function __construct(&$tree, $filter = false)
	{
		$this->tree = &$tree;
		$this->filter = $filter;
	}
	
	// iteration
	function rewind()
	{
		$this->position = -1;
		$this->real = -1;
		$this->next();
	}

	function current()
	{
		return new Tree($this->tree['inner'][$this->real]);
	}

	function key()
	{
		return $this->position;
	}

	function next()
	{
		++$this->position;
		
		if (!$this->filter)
			++$this->real;
		else
		{
			do
			{
				++$this->real;
			}
			while ($this->valid() && $this->tree['inner'][$this->real]['element'] != $this->filter);
		}
	}

	public function count()
	{
		if (!$this->filter)
			return count($this->tree['inner']);
		
		$cnt = 0;
		foreach ($this->tree['inner'] as $el)
			if ($el['element'] == $this->filter)
				++$cnt;
		return $cnt;
	}

	function valid()
	{
		return isset($this->tree['inner'][$this->real]);
	}
	
	// access
	public function offsetExists($offset)
	{
		// var_dump(__METHOD__,$this->tree['element'],$this->filter,$offset);
		if ($offset[0] == "@")
		{
			$offset = substr($offset, 1);
			return isset($this->tree['attributes'][$offset]);
		}
		if (is_int($offset))
		{
			if (!$this->filter)
				return isset($this->tree['inner'][$offset]);
			
			$cnt = -1;
			foreach ($this->tree['inner'] as $el)
				if ($el['element'] == $this->filter)
				{
					++$cnt;
					if ($cnt == $offset)
						return true;
				}
			return false;
		}
		else
			return true;
	}

	public function offsetGet($offset)
	{
		// var_dump(__METHOD__,$this->tree['element'],$this->filter,$offset);
		if ($offset[0] == "@")
		{
			if ($offset == "@!element")
				return $this->tree['element'];
			$offset = substr($offset, 1);
			return $this->tree['attributes'][$offset];
		}
		if (is_int($offset))
		{
			if (!$this->filter)
				return new Tree($this->tree['inner'][$offset]);
			
			$cnt = -1;
			// var_dump($this->tree['element'],$this->filter);
			foreach ($this->tree['inner'] as $el)
				if ($el['element'] == $this->filter)
				{
					++$cnt;
					if ($cnt == $offset)
						return new Basic($el);
				}
			return null;
		}
		else
			return new Basic($this->tree, $offset);
	}

	public function offsetSet($offset, $value)
	{
		/* no way */
	}

	public function offsetUnset($offset)
	{
		/* no way */
	}
}
