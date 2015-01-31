<?php

namespace Framework\Frontend;

/**
 * @package Framework
 * @subpackage Frontend
 */
abstract class HTMLLayout extends \Framework\Core\Object {
	private $view;
	
	public function construct($view) {
		$this->view = $view;
	}
	
	public function getView() {
		return $this->view;
	}
	
	abstract public function content();
}

?>