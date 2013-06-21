<?php

namespace Framework\Views;

/**
 * @package Framework
 * @subpackage Views
 */
class ForbiddenTransformView extends TransformView {
	public function header() {
		return $_SERVER['SERVER_PROTOCOL'].' 403 Forbidden';
	}
	
	public function content() {
		return '';
	}
}

?>