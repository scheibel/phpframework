<?php

namespace Framework\Tests\Core;

/**
 * @package Framework
 * @subpackage Tests
 */
class LazyWrapper extends Wrapper {
	public function setUp() {
		$this->wrapper = \Framework\Core\LazyWrapper::instance(function() {
			return \Framework\Tests\Stubs\Wrappee::instance();
		});
	}
}

?>