<?php

namespace Framework\Cronjob;

/**
 * @package Framework
 * @subpackage Cronjob
 */
abstract class Initializer extends \Framework\Core\Singleton {
	public static function nullInstanceClass() {
		return __NAMESPACE__.'\\NullInitializer';
	}
	
	public static function initializerFor($namespace) {
		$initializer = $namespace.'\\Cronjob\\Initializer';
		
		try {
			return $initializer::instance();
		} catch (Exception $e) {
			return static::nullInstance();
		}
	}
	
	abstract public function initialize($request, $response, $session);
}

?>