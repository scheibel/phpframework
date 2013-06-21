<?php

namespace Framework\Tests\Core;

/**
 * @package Framework
 * @subpackage Tests
 */
class Singleton extends \Framework\Testing\TestCase {
	protected function setUp() {
		$this->singleton1 = \Framework\Tests\Stubs\Singleton::instance();
		$this->singleton2 = \Framework\Tests\Stubs\Singleton::instance();
	}
	
	public function testSingleInstance() {
		$this->assert($this->singleton1->equals($this->singleton2));
	}
}

?>