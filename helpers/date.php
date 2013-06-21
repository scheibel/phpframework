<?php

namespace Framework\Helpers;

/**
 * @package Framework
 * @subpackage Helpers
 */
abstract class Date extends \Framework\Core\Helper {
	public static function secondsPerDay() {
		return 86400;
	}
	
	public static function stringToTimestamp($string, $format='') {
		if ($format) {
			$array = strptime($string, $format);
			
			if ($array) {
				return mktime($array['tm_hour'], $array['tm_min'], $array['tm_sec'], $array['tm_mon']+1, $array['tm_mday'], $array['tm_year'] + 1900);
			} else {
				return false;
			}
		} else {
			return strtotime($string);
		}
	}
}

?>