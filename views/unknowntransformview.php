<?php

namespace Framework\Views;

/**
 * @package Framework
 * @subpackage Views
 */
class UnknownTransformView extends TransformView {
	public function header() {
		return '404 Not Found';
	}
	
	public function content() {
		return '';
	}
}

?>