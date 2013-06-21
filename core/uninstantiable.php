<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */

abstract class Uninstantiable extends ProtoObject {
	private function __construct() {
		throw new \Exception("Can't instantiate ".get_called_class());
	}
}

?>