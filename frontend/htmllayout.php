<?php

namespace Framework\Frontend;

/**
 * @package Framework
 * @subpackage Frontend
 */
abstract class HTMLLayout extends \Framework\Core\Singleton {
	abstract public function content();
}

?>