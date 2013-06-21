<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */

class Dictionary extends Collection implements \ArrayAccess {
	public function getIterator() {
		$data = array();
		
		foreach ($this->data as $association) {
			$data[$association->key()] = $association->value();
		}
		
		return new \ArrayIterator($data);
	}
	
	public function add($association) {
		$this->data[$this->hashValue($association->key())] = $association;
	}
	
	public function remove($value) {
		$key = $this->keyOf($value);
		
		if ($key) {
			$this->removeKey($key);
		}
	}
	
	public function removeKey($key) {
		unset($this->data[$this->hashValue($key)]);
	}
	
	public function hasKey($key) {
		return isset($this->data[$this->hashValue($key)]);
	}
	
	public function at($key) {
		if ($this->hasKey($key)) {
			return $this->data[$this->hashValue($key)]->value();
		}
		
		return null;
	}
	
	public function atIfAbsent($key, $value) {
		if ($this->hasKey($key)) {
			return $this->data[$this->hashValue($key)]->value();
		}
		
		return $value;
	}
	
	public function atIfAbsentPut($key, $value) {
		if (!$this->hasKey($key)) {
			$this->atPut($key, $value);
		}
		
		return $this->at($key);
	}
	
	public function atPut($key, $value) {
		$this->add(Association::instance($key, $value));
	}
	
	public function keyOf($value) {
		foreach ($this->data as $hash=>$association) {
			if ($this->objectsEqual($association->value(), $value)) {
				return $association->key();
			}
		}
		
		return null;
	}
	
	protected function hashValue($value) {
		if ($value instanceof Object) {
			return $value->hash();
		} elseif (is_object($value)) {
			return spl_object_hash($value);
		} else {
			return $value;
		}
	}
	
	public function offsetExists($index) {
		return $this->hasKey($index);
	}
	
	public function offsetGet($index) {
		return $this->at($index);
	}
	
	public function offsetSet($index, $value) {
		$this->atPut($index, $value);
	}
	
	public function offsetUnset($index) {
		$this->removeKey($index);
	}
}

?>