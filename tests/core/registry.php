<?php

namespace Framework\Tests\Core;

/**
 * @package Framework
 * @subpackage Tests
 */
class Registry extends \Framework\Testing\TestCase {
	protected function setUp() {
		$this->registry = \Framework\Core\Registry::instance();
	}
	
	public function testIsSingleton() {
		$registry = \Framework\Core\Registry::instance();
		
		$this->assert($this->registry->equals($registry));
	}
	
	public function testValues() {
		$this->registry->setValue("Testkey", "Testvalue");
		
		$this->assert($this->registry->getValue("Testkey") == "Testvalue");
	}
}

?>