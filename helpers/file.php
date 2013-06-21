<?php

namespace Framework\Helpers;

/**
 * @package Framework
 * @subpackage Helpers
 */
abstract class File extends \Framework\Core\Helper {
	public static function exists($fileName) {
		return @file_exists($fileName);
	}
}

?>