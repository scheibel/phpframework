<?php

namespace Framework\Tests\Core;

/**
 * @package Framework
 * @subpackage Tests
 */
class OrderedCollection extends ValuedCollection {
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
	
	public function collectionInstance() {
		return \Framework\Core\OrderedCollection::instance();
	}
	
	public function implodeResult() {
		return "value, anothervalue";
	}
	
	public function sequence() {
		return array("value1", "value2", "value3");
	}
	
	public function collectFunction() {
		return function($value) {
			return "new".$value;
		};
	}
	
	public function collectionClass() {
		return "\\Framework\\Core\\OrderedCollection";
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class EmptyOrderedCollection extends EmptyValuedCollection {
	protected static function dataProvider() {
		return OrderedCollection::instance();
	}
	
	public function testNoExistentIndexOf() {
		$this->deny($this->collection->indexOf("nonexistentvalue"));
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class OneSizedOrderedCollection extends OneSizedValuedCollection {
	protected static function dataProvider() {
		return OrderedCollection::instance();
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class MoreSizedOrderedCollection extends MoreSizedValuedCollection {
	protected static function dataProvider() {
		return OrderedCollection::instance();
	}
	
	public function testSequencedAdding() {
		foreach ($this->collection as $index=>$value) {
			$this->assertEquals($this->sequence[$index], $value);
		}
	}
	
	public function testAt() {
		for ($i=0; $i<$this->collection->size(); $i++) {
			$this->assertEquals($this->sequence[$i], $this->collection->at($i));
		}
	}
	
	public function testIndexOf() {
		for ($i=0; $i<$this->collection->size(); $i++) {
			$this->assertEquals($i, $this->collection->indexOf($this->sequence[$i]));
		}
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class OrderedCollectionStaticInterface extends ValuedCollectionStaticInterface {
	protected static function dataProvider() {
		return OrderedCollection::instance();
	}
}

?>