<?php

namespace Framework\Tests\Core;

/**
 * @package Framework
 * @subpackage Tests
 */
class ProtoObject extends \Framework\Testing\TestCase {
	protected function setUp() {
		$this->emptyObject = \Framework\Tests\Stubs\ProtoObject::instance();
	}
	
	public function testInstantiation() {
		$this->assertInstanceOf("\\Framework\\Tests\\Stubs\\ProtoObject", $this->emptyObject);
	}
	
	public function testPerformWithArray() {
		$this->assert($this->emptyObject->performWithArgumentsArray('performTest', array()));
	}
	
	public function testPerform() {
		$this->assert($this->emptyObject->perform('performTest'));
	}
	
	public function testHash() {
		$this->assertEquals(spl_object_hash($this->emptyObject), $this->emptyObject->hash());
	}
	
	public function testRespondsTo() {
		$this->assert($this->emptyObject->respondsTo("performTest"));
	}
	
	public function testNegativeRespondsTo() {
		$this->deny($this->emptyObject->respondsTo("nonExistingMethod"));
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class ProtoObjectStaticInterface extends \Framework\Testing\TestCase {
	public function testStaticPerformWithArray() {
		$this->assert(\Framework\Tests\Stubs\ProtoObject::performStaticWithArgumentsArray('performStaticTest', array()));
	}
	
	public function testStaticPerform() {
		$this->assert(\Framework\Tests\Stubs\ProtoObject::performStatic('performStaticTest'));
	}
}

?>