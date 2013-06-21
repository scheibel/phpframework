<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */
class Registry extends Singleton {
	private $values;
	
	public function construct() {
		$this->values = Dictionary::instance();
	}
	
	public function getValue($key) {
		return $this->values->at($key);
	}
	
	public function setValue($key, $value) {
		$this->values->atPut($key, $value);
	}
	
	public function hasKey($key) {
		return $this->values->hasKey($key);
	}
}

?>