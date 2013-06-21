<?php

namespace Framework\Tests\Stubs;

/**
 * @package Framework
 * @subpackage Stubs
 */

class NullableObject extends \Framework\Core\Object {
	public static function nullInstanceClass() {
		return __NAMESPACE__.'\\NullObject';
	}
}

?>