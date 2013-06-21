<?php

namespace Framework\Frontend;

/**
 * @package Framework
 * @subpackage Frontend
 */
class Session extends \Framework\Core\VariableSingleton {
	public static function setSessionClass($sessionClass) {
		static::setSingletonClass($sessionClass);
	}
	
	public function __get($key) {
		return isset($_SESSION[$key])?$_SESSION[$key]:null;
	}
	
	public function __set($key, $value) {
		$_SESSION[$key] = $value;
	}
}

?>