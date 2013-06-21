<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */

class OrderedCollection extends ValuedCollection implements \ArrayAccess {
	public function add($object) {
		$this->data[$this->size()] = $object;
	}
	
	public function at($index) {
		return $this->data[$index];
	}
	
	public function atPut($index, $value) {
		$this->data[$index] = $value;
	}
	
	public function indexOf($object) {
		foreach ($this as $index=>$each) {
			if ($this->objectsEqual($each, $object)) {
				return $index;
			}
		}
		
		return false;
	}
	
	public function offsetExists($index) {
		return isset($this->data[$index]);
	}
	
	public function offsetGet($index) {
		return $this->at($index);
	}
	
	public function offsetSet($index, $value) {
		$this->atPut($index, $value);
	}
	
	public function offsetUnset($index) {
		unset($this->data[$index]);
	}
}

?>