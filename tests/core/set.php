<?php

namespace Framework\Tests\Core;

/**
 * @package Framework
 * @subpackage Tests
 */
class Set extends ValuedCollection {
	public function collectionTestElement() {
		return "value";
	}
	
	public function anotherCollectionTestElement() {
		return "anothervalue";
	}
	
	public function collectionRemoveTestElement() {
		return $this->collectionTestElement();
	}
	
	public function anotherCollectionRemoveTestElement() {
		return $this->anotherCollectionTestElement();
	}
	
	public function implodeResult() {
		return "value, anothervalue";
	}
	
	public function collectionInstance() {
		return \Framework\Core\Set::instance();
	}
	
	public function collectionClass() {
		return "\\Framework\\Core\\Set";
	}
	
	public function collectFunction() {
		return function($value) {
			return "new".$value;
		};
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class EmptySet extends EmptyValuedCollection {
	protected static function dataProvider() {
		return Set::instance();
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class OneSizedSet extends OneSizedValuedCollection {
	protected static function dataProvider() {
		return Set::instance();
	}
	
	public function testMultipleAdding() {
		$oldSize = $this->collection->size();
		$this->collection->add(static::collectionTestElement());
		$this->assertEquals($oldSize, $this->collection->size());
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class SetStaticInterface extends ValuedCollectionStaticInterface {
	protected static function dataProvider() {
		return Set::instance();
	}
}

?>