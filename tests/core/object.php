<?php

namespace Framework\Tests\Core;

/**
 * @package Framework
 * @subpackage Tests
 */
class Object extends \Framework\Testing\DataProvider {
	public function emptyObjectInstance() {
		return \Framework\Tests\Stubs\Object::instance();
	}
	
	public function getNamespacedClassName() {
		return \Framework\Tests\Stubs\Object::namespacedClassName();
	}
	
	public function getClassName() {
		return \Framework\Tests\Stubs\Object::className();
	}
	
	public function getProjectName() {
		return \Framework\Tests\Stubs\Object::projectName();
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class EmptyObject extends \Framework\Testing\TestCase {
	protected static function dataProvider() {
		return Object::instance();
	}
	
	protected function setUp() {
		$this->emptyObject = static::emptyObjectInstance();
	}
	
	public function testNull() {
		$this->deny($this->emptyObject->isNull());
	}
	
	public function testNotNull() {
		$this->assert($this->emptyObject->isNotNull());
	}
	
	public function testIsWrapper() {
		$this->deny($this->emptyObject->isWrapper());
	}
	
	public function testWrappedObject() {
		$this->assert($this->emptyObject->equals($this->emptyObject->nonWrappedObject()));
	}
	
	public function testReflexiveEquality() {
		$this->assert($this->emptyObject->equals($this->emptyObject));
	}
	
	public function testReflexiveDiffering() {
		$this->deny($this->emptyObject->differs($this->emptyObject));
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class ObjectComparison extends \Framework\Testing\TestCase {
	protected static function dataProvider() {
		return Object::instance();
	}
	
	protected function setUp() {
		$this->object1 = static::emptyObjectInstance();
		$this->object2 = static::emptyObjectInstance();
	}
	
	public function testTwoObjectsDiffer() {
		$this->assert($this->object1->differs($this->object2));
	}
	
	public function testTwoObjectsArentEqual() {
		$this->deny($this->object1->equals($this->object2));
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class ObjectStaticInterface extends \Framework\Testing\TestCase {
	protected static function dataProvider() {
		return Object::instance();
	}
	
	public function testNamespacedClassName() {
		$this->assertEquals("Framework\\Tests\\Stubs\\Object", static::getNamespacedClassName());
	}
	
	public function testClassName() {
		$this->assertEquals("Object", static::getClassName());
	}
	
	public function testProjectName() {
		$this->assertEquals("Framework", static::getProjectName());
	}
}

?>