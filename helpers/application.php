<?php

namespace Framework\Helpers;

/**
 * @package Framework
 * @subpackage Helpers
 */
abstract class Application extends \Framework\Core\Helper {
	public static function initializeSystem($config, $request, $response) {
		session_start();
		
		ini_set('display_errors', $config['displayErrors']);
		ini_set('xdebug.max_nesting_level', 500);
		
		date_default_timezone_set('Europe/Berlin');
		
		\Framework\Frontend\FrontControllerHandler::setControllerNamespace($config['controllerNamespace']);
		\Framework\Frontend\Session::setSessionClass($config['sessionClass']);
		\Framework\Views\TemplatedTransformView::setLayoutClass($config['layoutClass']);
		
		$request->setGet($_GET);
		$request->setPost($_POST);
		$request->setFiles($_FILES);
		$request->setEnvironment($_SERVER);
	}
}

?>