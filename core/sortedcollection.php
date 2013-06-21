<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */

class SortedCollection extends OrderedCollection {
	private $sortFunction;
	
	public function construct($sortFunction) {
		parent::construct();
		
		$this->sortFunction = $sortFunction;
		
		$this->addAll(array_slice(func_get_args(), 1));
	}
	
	public function addAll($set) {
		foreach ($set as $object) {
			parent::add($object);
		}
		
		$this->sort();
	}
	
	public function add($object) {
		parent::add($object);
		
		$this->sort();
	}
	
	public function sort() {
		if ($this->sortFunction) {
			$array = $this->data->getArrayCopy();
			
			usort($array, $this->sortFunction);
			
			$this->data->exchangeArray($array);
		}
	}
	
	protected function emptyInstance() {
		return static::instance($this->sortFunction);
	}
}

?>