<?php

namespace Framework\Tests\Stubs;

/**
 * @package Framework
 * @subpackage Stubs
 */

class Wrappee extends \Framework\Core\Object {
	public $value;
	
	public function test() {
		return true;
	}
}

?>