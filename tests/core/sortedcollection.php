<?php

namespace Framework\Tests\Core;

/**
 * @package Framework
 * @subpackage Tests
 */
class SortedCollection extends OrderedCollection {
	public function collectionTestElement() {
		return 5;
	}
	
	public function anotherCollectionTestElement() {
		return 3;
	}
	
	public function collectionRemoveTestElement() {
		return static::collectionTestElement();
	}
	
	public function anotherCollectionRemoveTestElement() {
		return static::anotherCollectionTestElement();
	}
	
	public function sortFunction() {
		return function($a, $b) {
			if ($a == $b) {
				return 0;
			}
			
			return $a < $b ? -1 : 1;
		};
	}
	
	public function sequence() {
		return array(4, 2, 7, 1, 5, 6, 3);
	}
	
	public function collectionInstance() {
		return \Framework\Core\SortedCollection::instance(static::sortFunction());
	}
	
	public function collectFunction() {
		return function($value) {
			return 2+$value;
		};
	}
	
	public function implodeResult() {
		return "3, 5";
	}
	
	public function collectionClass() {
		return "\\Framework\\Core\\SortedCollection";
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class EmptySortedCollection extends EmptyOrderedCollection {
	protected static function dataProvider() {
		return SortedCollection::instance();
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class OneSizedSortedCollection extends OneSizedOrderedCollection {
	protected static function dataProvider() {
		return SortedCollection::instance();
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class CastedSortedCollection extends \Framework\Testing\TestCase {
	protected static function dataProvider() {
		return SortedCollection::instance();
	}
	
	protected function setUp() {
		$this->collection = \Framework\Core\OrderedCollection::instance(3, 1, 6, 2)->sortBy(static::sortFunction());
	}
	
	public function testIsSorted() {
		$oldValue = 0;
		for ($i=0; $i<$this->collection->size(); $i++) {
			$this->assert($this->collection->at($i)>$oldValue);
			
			$oldValue = $this->collection->at($i);
		}
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class SortedCollectionStaticInterface extends OrderedCollectionStaticInterface {
	protected static function dataProvider() {
		return SortedCollection::instance();
	}
}

?>