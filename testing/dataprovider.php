<?php

namespace Framework\Testing;

/**
 * @package Framework
 * @subpackage Testing
 */
class DataProvider extends \Framework\Core\Singleton {
	public static function nullInstanceClass() {
		return __NAMESPACE__."\\NullDataProvider";
	}
}

/**
 * @package Framework
 * @subpackage Testing
 */
class NullDataProvider extends \Framework\Core\NullObject {
	
}

?>