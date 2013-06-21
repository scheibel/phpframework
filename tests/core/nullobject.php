<?php

namespace Framework\Tests\Core;

/**
 * @package Framework
 * @subpackage Tests
 */
class NullObject extends \Framework\Testing\TestCase {
	public function setUp() {
		$this->nullObject = \Framework\Tests\Stubs\NullableObject::nullInstance();
	}
	
	public function testNull() {
		$this->assert($this->nullObject->isNull());
	}
	
	public function testNotNull() {
		$this->deny($this->nullObject->isNotNull());
	}
	
	public function testNullInstantiation() {
		$this->assertInstanceOf("\\Framework\\Tests\\Stubs\\NullObject", $this->nullObject);
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class StandardNullObject extends \Framework\Testing\TestCase {
	public function setUp() {
		$this->standardNullObject = \Framework\Tests\Stubs\Object::nullInstance();
	}
	
	public function testStandardNullInstantiation() {
		$this->assertInstanceOf("\\Framework\\Core\\NullObject", $this->standardNullObject);
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class NullObjectStaticInterface extends \Framework\Testing\TestCase {
	public function testNullClass() {
		$this->assertEquals("Framework\\Tests\\Stubs\\NullObject", \Framework\Tests\Stubs\NullableObject::nullInstanceClass());
	}
	
	public function testStandardNullClass() {
		$this->assertEquals("Framework\\Core\\NullObject", \Framework\Core\Object::nullInstanceClass());
	}
}

?>