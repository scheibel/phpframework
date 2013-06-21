<?php

namespace Framework\Tests\Core;

/**
 * @package Framework
 * @subpackage Tests
 */
abstract class Collection extends \Framework\Testing\DataProvider {
	abstract public function collectionTestElement();
	abstract public function anotherCollectionTestElement();
	abstract public function collectionRemoveTestElement();
	abstract public function anotherCollectionRemoveTestElement();
	abstract public function collectionInstance();
}

/**
 * @package Framework
 * @subpackage Tests
 */
abstract class EmptyCollection extends \Framework\Testing\TestCase {
	protected static function dataProvider() {
		return Collection::instance();
	}
	
	protected function setUp() {
		$this->collection = static::collectionInstance();
	}
	
	public function testNewInstanceIsEmpty() {
		$this->assertEmpty($this->collection);
	}
	
	public function testInstanceHasSizeOfZero() {
		$this->assertEquals(0, $this->collection->size());
	}
	
	public function testAdding() {
		$this->collection->add(static::collectionTestElement());
		
		$this->assertEquals(1, $this->collection->size());
	}
	
	public function testEmptyIterating() {
		foreach ($this->collection as $key=>$value) {
			$this->fail();
		}
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
abstract class OneSizedCollection extends \Framework\Testing\TestCase {
	protected static function dataProvider() {
		return Collection::instance();
	}
	
	protected function setUp() {
		$this->collection = static::collectionInstance();
		$this->collection->add(static::collectionTestElement());
	}
	
	public function testInstanceWithOneElementIsNotEmpty() {
		$this->assertNotEmpty($this->collection);
	}
	
	public function testInstanceWithOneElementHasSizeOfOne() {
		$this->assertEquals(1, $this->collection->size());
	}
	
	public function testRemoving() {
		$this->collection->remove(static::collectionRemoveTestElement());
		
		$this->assertEmpty($this->collection);
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
abstract class CollectionStaticInterface extends \Framework\Testing\TestCase {
	protected static function dataProvider() {
		return Collection::instance();
	}
	
	public function testNullInstanceClassIsSameClass() {
		$className = static::collectionClass();
		
		$this->assertEquals($className::namespacedClassName(), $className::nullInstanceClass());
	}
}

?>