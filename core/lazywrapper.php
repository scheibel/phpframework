<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */

class LazyWrapper extends Wrapper {
	private $__initializationBlock;
	
	public function construct($initializationBlock) {
		parent::construct(null);
		
		$this->__initializationBlock = $initializationBlock;
	}
	
	public function equals($object) {
		return $this->__call("equals", array($object));
	}
	
	protected function __ensureWrappee() {
		if (!$this->__isWrapped()) {
			$block = $this->__initializationBlock;
			
			$this->__setWrappee($block());
		}
	}
	
	public function __isWrapped() {
		return !is_null($this->__getWrappee());
	}
	
	public function __get($variableName) {
		$this->__ensureWrappee();
		
		return parent::__get($variableName);
	}
	
	public function __set($variableName, $value) {
		$this->__ensureWrappee();
		
		return parent::__set($variableName, $value);
	}
	
	public function __call($methodName, $arguments) {
		$this->__ensureWrappee();
		
		return parent::__call($methodName, $arguments);
	}
}

?>