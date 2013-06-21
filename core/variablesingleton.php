<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */
class VariableSingleton extends Singleton {
	protected static $__soleClasses = array();
	
	public static function setSingletonClass($className) {
		static::$__soleClasses[static::completeClassName()] = $className::namespacedClassName();
	}
	
	public static function currentSingletonClass() {
		return static::$__soleClasses[static::completeClassName()];
	}
	
	public static function resetSingletonClass() {
		static::$__soleClasses[static::completeClassName()] = static::completeClassName();
		unset(static::$__soleInstances[static::completeClassName()]);
	}
	
	protected static function hasSingleton($className) {
		return parent::hasSingleton($className) && (static::$__soleInstances[$className::namespacedClassName()] instanceof static::$__soleClasses[$className::namespacedClassName()]);
	}
	
	protected static function newSingletonInstance() {
		return static::newInstance(isset(static::$__soleClasses[static::completeClassName()])?static::$__soleClasses[static::completeClassName()]:static::completeClassName());
	}
}

?>