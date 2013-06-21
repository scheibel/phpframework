<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */

abstract class ProtoObject {
	private function __construct() {
		
	}
	
	public function construct() {
		
	}
	
	public function equals($object) {
		return $this->nonWrappedObject() === $object->nonWrappedObject();
	}
	
	public function differs($object) {
		return !$this->equals($object);
	}
	
	public function perform($method) {
		return $this->performWithArgumentsArray($method, array_slice(func_get_args(), 1));
	}
	
	public function performWithArgumentsArray($method, $arguments) {
		return call_user_func_array(array($this, $method), $arguments);
	}
	
	public function hash() {
		return spl_object_hash($this->nonWrappedObject());
	}
	
	public function respondsTo($method) {
		return method_exists($this, $method);
	}
	
	abstract public function isWrapper();
	abstract public function isNull();
	abstract public function isNotNull();
	abstract public function nonWrappedObject();
	
	public static function instance() {
		return static::performStaticWithArgumentsArray('newInstance', array_merge(array(get_called_class()), func_get_args()));
	}
	
	protected static function newInstance($class) {
		$arguments = func_get_args();
		$class = array_shift($arguments);
		
		$object = new $class();
		
		$object->performWithArgumentsArray('construct', $arguments);
		
		return $object;
	}
	
	public static function performStatic($method) {
		return static::performStaticWithArgumentsArray($method, array_slice(func_get_args(), 1));
	}
	
	public static function performStaticWithArgumentsArray($method, $arguments) {
		return call_user_func_array(get_called_class().'::'.$method, $arguments);
	}
}

?>