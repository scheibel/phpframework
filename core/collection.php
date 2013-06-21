<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */
abstract class Collection extends Object implements \IteratorAggregate, \Countable {
	protected $data;
	
	public function construct() {
		$this->data = new \ArrayObject();
	}
	
	public function isEmpty() {
		return $this->size() == 0;
	}
	
	public function isNotEmpty() {
		return !$this->isEmpty();
	}
	
	public function size() {
		return $this->count();
	}
	
	public function count() {
		return count($this->data);
	}
	
	public function objectsEqual($object1, $object2) {
		if ($object1 instanceof ProtoObject && $object2 instanceof ProtoObject) {
			return $object1->equals($object2);
		} else {
			return $object1 === $object2;
		}
	}
	
	abstract public function add($object);
	abstract public function remove($object);
	
	public static function nullInstanceClass() {
		return static::namespacedClassName();
	}
}

?>