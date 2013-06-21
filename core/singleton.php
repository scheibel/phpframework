<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */

class Singleton extends Object {
	protected static $__soleInstances = array();
	
	public static function instance() {
		if (!static::hasSingleton(static::completeClassName())) {
			static::setSingleton(static::completeClassName(), static::newSingletonInstance());
		}
		
		return static::getSingleton(static::completeClassName());
	}
	
	protected static function newSingletonInstance() {
		return parent::instance();
	}
	
	protected static function hasSingleton($className) {
		return isset(static::$__soleInstances[$className]);
	}
	
	protected static function getSingleton($className) {
		return static::$__soleInstances[$className];
	}
	
	protected static function setSingleton($className, $instance) {
		static::$__soleInstances[$className] = $instance;
	}
}

?>