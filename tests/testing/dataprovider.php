<?php

namespace Framework\Tests\Testing;

/**
 * @package Framework
 * @subpackage Tests
 */
class NormalDataProvider extends \Framework\Testing\TestCase {
	protected static function dataProvider() {
		return \Framework\Tests\Stubs\DataProvider::instance();
	}
	
	public function testDataProvider() {
		$this->assert(static::trueValue());
	}
}

/**
 * @package Framework
 * @subpackage Tests
 */
class DataProviderNullInstance extends \Framework\Testing\TestCase {
	public function testNullInstance() {
		$this->assertInstanceOf("\\Framework\\Testing\\NullDataProvider", \Framework\Testing\DataProvider::nullInstance());
	}
	
	public function testNullValue() {
		$this->assertNull(static::trueValue());
	}
}

?>