<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */

abstract class ValuedCollection extends Collection {
	public function construct() {
		parent::construct();
		
		$this->addAll(func_get_args());
	}
	
	public function remove($object) {
		foreach ($this as $index=>$element) {
			if ($this->objectsEqual($element, $object)) {
				unset($this->data[$index]);
			}
		}
	}
	
	public function select($function) {
		$result = $this->emptyInstance();
		
		foreach ($this as $object) {
			if ($function($object)) {
				$result->add($object);
			}
		}
		
		return $result;
	}
	
	public function reject($function) {
		$result = $this->emptyInstance();
		
		foreach ($this as $object) {
			if (!$function($object)) {
				$result->add($object);
			}
		}
		
		return $result;
	}
	
	public function addAll($set) {
		foreach ($set as $object) {
			$this->add($object);
		}
	}
	
	public function copyWithAll($set) {
		$result = $this->emptyInstance();
		
		$result->addAll($this);
		$result->addAll($set);
		
		return $result;
	}
	
	public function anySatisfy($function) {
		foreach ($this->data as $object) {
			if ($function($object)) {
				return true;
			}
		}
		
		return false;
	}
	
	public function allSatisfy($function) {
		foreach ($this->data as $object) {
			if (!$function($object)) {
				return false;
			}
		}
		
		return true;
	}
	
	public function noneSatisfy($function) {
		return !$this->anySatisfy($function);
	}
	
	public function detect($function) {
		return $this->detectIfNone($function, null);
	}
	
	public function detectIfNone($function, $noneValue) {
		foreach ($this->data as $object) {
			if ($function($object)) {
				return $object;
			}
		}
		
		return $noneValue;
	}
	
	public function includes($object) {
		return $this->anySatisfy(function($each) use ($object) {
			return $each === $object;
		});
	}
	
	public function injectInto($object, $function) {
		foreach ($this as $element) {
			$object = $function($object, $element);
		}
		
		return $object;
	}
	
	public function sortBy($function) {
		$result = SortedCollection::instance($function);
		
		$result->addAll($this);
		
		return $result;
	}
	
	public function collect($function) {
		$result = $this->emptyInstance();
		
		foreach ($this as $element) {
			$result->add($function($element));
		}
		
		return $result;
	}
	
	public function implode($separatingFunction) {
		$result = null;
		
		$first = true;
		
		foreach ($this as $value) {
			if ($first) {
				$result = $value;
				
				$first = false;
			}else{
				$result = $separatingFunction($result, $value);
			}
		}
		
		return $result;
	}
	
	public function getIterator() {
		return new \ArrayIterator($this->data);
	}
	
	public function reversed() {
		return static::performStaticWithArgumentsArray('instance', array_reverse($this->data->getArrayCopy()));
	}
	
	protected function emptyInstance() {
		return static::instance();
	}
}

?>