<?php

namespace Framework\Commands;

/**
 * @package Framework
 * @subpackage Commands
 */
class UnknownCommand extends FrontControllerCommand {
	public function execute() {
		$this->response()->setContent(\Framework\Views\UnknownTransformView::instance()->content());
		$this->response()->setHeader(\Framework\Views\UnknownTransformView::instance()->header());
	}
}

?>