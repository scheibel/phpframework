<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */

class Association extends Object {
	private $key;
	private $value;
	
	public function construct($key, $value) {
		$this->key = $key;
		$this->value = $value;
	}
	
	public function key() {
		return $this->key;
	}
	
	public function value() {
		return $this->value;
	}
}

?>