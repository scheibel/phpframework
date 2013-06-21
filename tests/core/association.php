<?php

namespace Framework\Tests\Core;

/**
 * @package Framework
 * @subpackage Tests
 */
class Association extends \Framework\Testing\TestCase {
	public function setUp() {
		$this->association = \Framework\Core\Association::instance("key", "value");
	}
	
	public function testKey() {
		$this->assertEquals("key", $this->association->key());
	}
	
	public function testValue() {
		$this->assertEquals("value", $this->association->value());
	}
}

?>