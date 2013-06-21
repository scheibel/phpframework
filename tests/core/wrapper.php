<?php

namespace Framework\Tests\Core;

/**
 * @package Framework
 * @subpackage Tests
 */
class Wrapper extends \Framework\Testing\TestCase {
	public function setUp() {
		$this->wrapper = \Framework\Core\Wrapper::instance(\Framework\Tests\Stubs\Wrappee::instance());
	}
	
	public function testAccessors() {
		$this->wrapper->value = "Hallo";
		
		$this->assertEquals("Hallo", $this->wrapper->value);
		$this->assertEquals("Hallo", $this->wrapper->__getWrappee()->value);
	}
	
	public function testCalling() {
		$this->assertTrue($this->wrapper->test());
		$this->assertEquals($this->wrapper->test(), $this->wrapper->__getWrappee()->test());
	}
	
	public function testEquals() {
		$this->assert($this->wrapper->equals($this->wrapper->nonWrappedObject()));
	}
	
	public function testWrappedObject() {
		$this->assert($this->wrapper->nonWrappedObject()->equals($this->wrapper->__getWrappee()));
	}
	
	public function testIsWrapper() {
		$this->assert($this->wrapper->isWrapper());
	}
	
	public function testIsNull() {
		$this->assert($this->wrapper->isNull() == $this->wrapper->__getWrappee()->isNull());
	}
	
	public function testIsNotNull() {
		$this->assert($this->wrapper->isNotNull() == $this->wrapper->__getWrappee()->isNotNull());
	}
}

?>