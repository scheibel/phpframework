<?php

namespace Framework\Helpers;

/**
 * @package Framework
 * @subpackage Helpers
 */
abstract class Directory extends \Framework\Core\Helper {
	public static function exists($dirName) {
		return @file_exists($dirName);
	}
}

?>