<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */

class Wrapper extends ProtoObject {
	private $__wrappee;
	
	public function construct($wrappee) {
		$this->__wrappee = $wrappee;
	}
	
	public function isWrapper() {
		return true;
	}
	
	public function nonWrappedObject() {
		return $this->__call("nonWrappedObject", array());
	}
	
	public function isNull() {
		return $this->__call("isNull", array());
	}
	
	public function isNotNull() {
		return $this->__call("isNotNull", array());
	}
	
	public function __getWrappee() {
		return $this->__wrappee;
	}
	
	public function __setWrappee($wrappee) {
		$this->__wrappee = $wrappee;
	}
	
	public function __get($variableName) {
		return $this->__wrappee->$variableName;
	}
	
	public function __set($variableName, $value) {
		$this->__wrappee->$variableName = $value;
	}
	
	public function __call($methodName, $arguments) {
		return $this->__wrappee->performWithArgumentsArray($methodName, $arguments);
	}
}

?>