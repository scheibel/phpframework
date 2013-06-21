<?php

namespace Framework\Tests\Core;

/**
 * @package Framework
 * @subpackage Tests
 */
class VariableSingleton extends \Framework\Testing\TestCase {
	private $singletonClass;
	private $alternativeClass;
	
	protected function setUp() {
		$this->singletonClass = "Framework\\Tests\\Stubs\\VariableSingleton";
		$this->alternativeClass = "Framework\\Tests\\Stubs\\AlternativeVariableSingleton";
	}
	
	public function testStandardSingletonInstance() {
		$class = "\\".$this->singletonClass;
		
		$this->assertEquals($this->singletonClass, $class::instance()->namespacedClassName());
	}
	
	public function testCurrentSingletonClass() {
		$class = "\\".$this->singletonClass;
		
		$class::setSingletonClass("\\".$this->alternativeClass);
		
		$this->assertEquals($this->alternativeClass, $class::currentSingletonClass());
	}
	
	public function testVariableSingletonInstance() {
		$class = "\\".$this->singletonClass;
		
		$class::setSingletonClass("\\".$this->alternativeClass);
		
		$this->assertEquals($this->alternativeClass, $class::instance()->namespacedClassName());
	}
	
	public function testResetSingletonClass() {
		$class = "\\".$this->singletonClass;
		
		$class::setSingletonClass("\\".$this->alternativeClass);
		$class::resetSingletonClass();
		
		$this->assertEquals($this->singletonClass, $class::instance()->namespacedClassName());
	}
}

?>