<?php

namespace Framework\Testing;

/**
 * @package Framework
 * @subpackage Testing
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase {
	protected function getInstance($instance) {
		$class = array_pop(explode("\\", get_called_class()));
		
		return $this->getFactory($class, $instance);
	}
	
	protected function getFactory($class, $instance) {
		$project = array_shift(explode("\\", get_called_class()));
		
		return $this->getCompleteFactory($project, $class, $instance);
	}
	
	protected function getCompleteFactory($project, $class, $instance) {
		return Factory::instance()->getCompleteFactory($project, $class, $instance);
	}
	
	public static function assert($boolean, $message='') {
		static::assertTrue($boolean, $message);
	}
	
	public static function deny($boolean, $message='') {
		static::assertFalse($boolean, $message);
	}
	
	public static function assertEmpty($actual, $message = '') {
		static::assert($actual->isEmpty(), $message);
	}
	
	public static function assertNotEmpty($actual, $message = '') {
		static::assert($actual->isNotEmpty(), $message);
	}
	
	public static function assertSimpleAccessors($testObject, $variableObject, $getterMethod, $setterMethod, $message = '') {
		$testObject->perform($setterMethod, $variableObject);
		
		static::assertSame($variableObject, $testObject->perform($getterMethod), $message);
	}
	
	public static function assertCollectionAccessors($testObject, $variableObject, $getterMethod, $setterMethod, $addingMethod, $removingMethod, $message = '') {
		$variableCollection = \Framework\Core\Set::instance();
		
		$testObject->perform($setterMethod, $variableCollection);
		
		static::assertSame($variableCollection, $testObject->perform($getterMethod), $message);
		
		$testObject->perform($addingMethod, $variableObject);
		
		static::assert($testObject->perform($getterMethod)->includes($variableObject));
		
		$testObject->perform($removingMethod, $variableObject);
		
		static::deny($testObject->perform($getterMethod)->includes($variableObject));
	}
	
	public static function assertSameCollection($expectedCollection, $actualCollection, $message = '') {
		foreach ($expectedCollection as $item) {
			static::assert($actualCollection->includes($item), $message);
		}
		
		foreach ($actualCollection as $item) {
			static::assert($expectedCollection->includes($item), $message);
		}
	}
	
	protected static function dataProvider() {
		return DataProvider::nullInstance();
	}
	
	public static function __callStatic($method, $arguments) {
		return static::dataProvider()->performWithArgumentsArray($method, $arguments);
	}
}

?>