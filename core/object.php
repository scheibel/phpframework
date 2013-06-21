<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */

class Object extends ProtoObject {
	public function isNull() {
		return false;
	}
	
	public function isNotNull() {
		return true;
	}
	
	public function isWrapper() {
		return false;
	}
	
	public function nonWrappedObject() {
		return $this;
	}
	
	/* Statics */
	
	public static function nullInstance() {
		$className = "\\".static::nullInstanceClass();
		
		return $className::instance();
	}
	
	public static function nullInstanceClass() {
		return __NAMESPACE__.'\\NullObject';
	}
	
	public static function projectName() {
		return array_shift(static::classNameParts());
	}
	
	public static function className() {
		return array_pop(static::classNameParts());
	}
	
	public static function namespacedClassName() {
		return static::completeClassName();
	}
	
	protected static function completeClassName() {
		return get_called_class();
	}
	
	protected static function classNameParts() {
		return explode("\\", static::completeClassName());
	}
}

?>