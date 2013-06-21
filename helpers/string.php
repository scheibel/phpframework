<?php

namespace Framework\Helpers;

/**
 * @package Framework
 * @subpackage Helpers
 */
abstract class String extends \Framework\Core\Helper {
	public static function pluralize($count, $unit, $pluralSuffix) {
		return static::pluralizeReplacing($count, $unit, $unit.$pluralSuffix);
	}
	
	public static function pluralizeReplacing($count, $singular, $plural) {
		return $count==1?$singular:$plural;
	}
}

?>