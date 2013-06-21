<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */

class NullObject extends Singleton {
	public function isNull() {
		return true;
	}
	
	public function isNotNull() {
		return false;
	}
	
	public function __call($method, $arguments) {
		
	}
}

?>