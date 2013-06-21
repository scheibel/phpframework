<?php

namespace Framework\Tests\Stubs;

/**
 * @package Framework
 * @subpackage Stubs
 */

class ProtoObject extends \Framework\Core\ProtoObject {
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
	
	public function performTest() {
		return true;
	}
	
	public static function performStaticTest() {
		return true;
	}
}

?>