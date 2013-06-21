<?php

namespace Framework\Views;

/**
 * @package Framework
 * @subpackage Views
 */
abstract class LayoutedHTMLTransformView extends TransformView {
	public function header() {
		return 'Content-Type: text/html';
	}
	
	public function content() {
		$layout = $this->layoutClass();
		
		return $layout::instance()->content();
	}
	
	abstract protected function layoutClass();
}

?>