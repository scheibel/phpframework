<?php

namespace Framework\Tests\Core;

/**
 * @package Framework
 * @subpackage Tests
 */
abstract class ValuedCollection extends Collection {
	abstract public function collectFunction();
	abstract public function implodeResult();
	
	public function sequence() {
		return array("value1", "value2", "value3");
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
abstract class EmptyValuedCollection extends EmptyCollection {
	protected static function dataProvider() {
		return ValuedCollection::instance();
	}
	
	public function testAddAll() {
		$this->collection->addAll(array(1, 2, 3));
		
		foreach ($this->collection as $value) {
			$this->assert($value == 1 || $value == 2 || $value == 3);
		}
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
abstract class OneSizedValuedCollection extends OneSizedCollection {
	protected static function dataProvider() {
		return ValuedCollection::instance();
	}
	
	public function testSelect() {
		$this->collection->add(static::anotherCollectionTestElement());
		
		$testElement = static::collectionTestElement();
		
		$selected = $this->collection->select(function($element) use ($testElement) {
			return $element==$testElement;
		});
		
		$this->assertEquals(1, $selected->size());
		
		foreach ($selected as $value) {
			$this->assertEquals($testElement, $value);
		}
	}
	
	public function testReject() {
		$this->collection->add(static::anotherCollectionTestElement());
		
		$testElement = static::collectionTestElement();
		
		$selected = $this->collection->reject(function($element) use ($testElement) {
			return $element==$testElement;
		});
		
		$this->assertEquals(1, $selected->size());
		
		foreach ($selected as $value) {
			$this->assertEquals(static::anotherCollectionTestElement(), $value);
		}
	}
	
	public function testPositiveAnySatisfy() {
		$testElement = static::collectionTestElement();
		
		$this->assert($this->collection->anySatisfy(function($element) use ($testElement) { return $element==$testElement; }));
	}
	
	public function testNegativeAnySatisfy() {
		$testElement = static::anotherCollectionTestElement();
		
		$this->deny($this->collection->anySatisfy(function($element) use ($testElement) { return $element==$testElement; }));
	}
	
	public function testPositiveAllSatisfy() {
		$this->collection->add(static::anotherCollectionTestElement());
		
		$testElement1 = static::collectionTestElement();
		$testElement2 = static::anotherCollectionTestElement();
		
		$this->assert($this->collection->allSatisfy(function($element) use ($testElement1, $testElement2) { return $element==$testElement1 || $element == $testElement2; }));
	}
	
	public function testNegativeAllSatisfy() {
		$this->collection->add(static::anotherCollectionTestElement());
		
		$testElement = static::collectionTestElement();
		
		$this->deny($this->collection->allSatisfy(function($element) use ($testElement) { return $element==$testElement; }));
	}
	
	public function testPositiveNoneSatisfy() {
		$this->collection->add(static::anotherCollectionTestElement());
		
		$this->assert($this->collection->noneSatisfy(function($element) { return $element==-1; }));
	}
	
	public function testNegativeNoneSatisfy() {
		$this->collection->add(static::anotherCollectionTestElement());
		
		$testElement = static::collectionTestElement();
		
		$this->deny($this->collection->noneSatisfy(function($element) use ($testElement) { return $element==$testElement; }));
	}
	
	public function testPositiveDetect() {
		$testElement = static::collectionTestElement();
		
		$this->assertEquals($testElement, $this->collection->detect(function($element) use ($testElement) { return $element==$testElement; }));
	}
	
	public function testNegativeDetect() {
		$testElement = static::anotherCollectionTestElement();
		
		$this->assertNull($this->collection->detect(function($element) use ($testElement) { return $element==$testElement; }));
	}
	
	public function testInjectInto() {
		$this->assertEquals((string)static::collectionTestElement(), $this->collection->injectInto("", function($string, $element) { return $string.$element; }));
	}
	
	public function testImplode() {
		$this->collection->add(static::anotherCollectionTestElement());
		
		$this->assertEquals(static::implodeResult(), $this->collection->implode(function($result, $element) { return $result.", ".$element; }));
	}
	
	public function testCollect() {
		$collectFunction = static::collectFunction();
		$collected = $this->collection->collect($collectFunction);
		
		foreach ($collected as $value) {
			$this->assertEquals($collectFunction(static::collectionTestElement()), $value);
		}
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
abstract class MoreSizedValuedCollection extends \Framework\Testing\TestCase {
	protected static function dataProvider() {
		return ValuedCollection::instance();
	}
	
	protected function setUp() {
		$this->sequence = static::sequence();
		$this->collection = static::collectionInstance();
		$this->collection->addAll($this->sequence);
	}
	
	public function testCopyWithAll() {
		$newCollection = $this->collection->copyWithAll(array(4));
		
		$this->deny($newCollection->equals($this->collection));
		
		foreach ($newCollection as $value) {
			$this->assert($value == $this->sequence[0] || $value == $this->sequence[1] || $value == $this->sequence[2] || $value == 4);
		}
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
abstract class ValuedCollectionStaticInterface extends CollectionStaticInterface {
	protected static function dataProvider() {
		return ValuedCollection::instance();
	}
}

?>