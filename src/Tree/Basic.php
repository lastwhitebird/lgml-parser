<?php

namespace LWB\LGMLParser\Tree;

class Basic implements \Iterator, \ArrayAccess, \Countable
{
	var $tree = null;
	var $filter = false;
	var $position = 0;
	var $real = 0;

	public function __construct()
	{
		$this->tree = [
				'element' => '', 
				'attributes' => [], 
				'inner' => [] 
		];
	}

	public static function factoryFromTree(&$tree, $filter = false)
	{
		$class = get_called_class();
		$the = new $class();
		if (count($tree) == 1)
			$tree = &$tree[0];
		$the->tree = &$tree;
		$the->filter = $filter;
		return $the;
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
		$class = get_class($this);
		return call_user_func([
				$class, 
				'factoryFromTree' 
		], [
				&$this->tree['inner'][$this->real] 
		]);
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
		if ($offset[0] == "@")
		{
			$offset = substr($offset, 1);
			if ($offset === false)
				return true;
			else
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
		if ($offset[0] == "@")
		{
			if ($offset == "@!element")
				return $this->tree['element'];
			$offset = substr($offset, 1);
			if ($offset === false)
			{
				return $this->tree['attributes'];
			}
			else
				return $this->tree['attributes'][$offset];
		}
		$class = get_class($this);
		if (is_int($offset))
		{
			if (!$this->filter)
			{
				$inner = &$this->tree['inner'];
				$real = $inner[$offset];
				return call_user_func([
						$class, 
						'factoryFromTree' 
				], [
						&$this->tree['inner'][$offset]
				]);
			}
			$cnt = -1;
			foreach ($this->tree['inner'] as $el)
				if ($el['element'] == $this->filter)
				{
					++$cnt;
					if ($cnt == $offset)
					{
						return call_user_func([
								$class, 
								'factoryFromTree' 
						], [
								&$el 
						]);
					}
				}
			return null;
		}
		else
			return call_user_func([
					$class, 
					'factoryFromTree' 
			], [
					&$this->tree 
			], $offset);
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
