<?php

namespace Framework\Tests\Core;

/**
 * @package Framework
 * @subpackage Tests
 */
class Dictionary extends Collection {
	public function collectionTestElement() {
		return \Framework\Core\Association::instance("key", "value");
	}
	
	public function collectionRemoveTestElement() {
		return "value";
	}
	
	public function anotherCollectionTestElement() {
		return \Framework\Core\Association::instance("key2", "value2");
	}
	
	public function anotherCollectionRemoveTestElement() {
		return "value2";
	}
	
	public function collectionInstance() {
		return \Framework\Core\Dictionary::instance();
	}
	
	public function collectionClass() {
		return "\\Framework\\Core\\Dictionary";
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class EmptyDictionary extends EmptyCollection {
	protected static function dataProvider() {
		return Dictionary::instance();
	}
	
	public function testAtPut() {
		$this->collection->atPut("anotherkey", "anothervalue");
		
		$this->assertNotEmpty($this->collection);
	}
	
	public function testAtIfAbsentPutEmptyCollection() {
		$this->collection->add(static::collectionTestElement());
		
		$this->assertEquals("anothervalue", $this->collection->atIfAbsentPut("anotherkey", "anothervalue"));
		$this->assertEquals("anothervalue", $this->collection->at("anotherkey"));
	}
	
	public function testAtIfAbsentPutExistentKey() {
		$this->collection->add(static::collectionTestElement());
		
		$this->assertEquals("value", $this->collection->atIfAbsentPut("key", "anothervalue"));
		
		$this->assertEquals("value", $this->collection->at("key"));
	}
	
	public function testFrameworkObjectDictionaries() {
		$this->collection->atPut(\Framework\Tests\Stubs\Object::instance(), 4);
	}
	
	public function testObjectDictionaries() {
		$this->collection->atPut(new \stdClass, 4);
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class OneSizedDictionary extends OneSizedCollection {
	protected static function dataProvider() {
		return Dictionary::instance();
	}
	
	public function testNonEmptyIterating() {
		foreach ($this->collection as $key=>$value) {
			$this->assertEquals("key", $key);
			$this->assertEquals("value", $value);
		}
	}
	
	public function testExistentKey() {
		$this->assert($this->collection->hasKey("key"));
	}
	
	public function testNonExistentKey() {
		$this->deny($this->collection->hasKey("nonexistentkey"));
	}
	
	public function testExistentValue() {
		$this->assertEquals("value", $this->collection->at("key"));
	}
	
	public function testNonExistentValue() {
		$this->assertNull($this->collection->at("nonexistentkey"));
	}
	
	public function testExistentKeyOfValue() {
		$this->assertEquals("key", $this->collection->keyOf("value"));
	}
	
	public function testNonExistentKeyOfValue() {
		$this->assertNull($this->collection->keyOf("nonexistentvalue"));
	}
	
	public function testAtIfAbsentExistentKey() {
		$this->assertEquals("value", $this->collection->atIfAbsent("key", "anothervalue"));
	}
	
	public function testAtIfAbsentNonExistentKey() {
		$this->assertEquals("anothervalue", $this->collection->atIfAbsent("nonexistentkey", "anothervalue"));
	}
	
	public function testAtIfAbsentPutNonExistentKey() {
		$this->collection->add(static::collectionTestElement());
		
		$this->assertEquals("anothervalue", $this->collection->atIfAbsentPut("anotherkey", "anothervalue"));
		
		$this->assertEquals("anothervalue", $this->collection->at("anotherkey"));
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class DictionaryStaticInterface extends CollectionStaticInterface {
	protected static function dataProvider() {
		return Dictionary::instance();
	}
}

?>