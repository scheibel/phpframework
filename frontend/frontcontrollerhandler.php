<?php

namespace Framework\Frontend;

/**
 * @package Framework
 * @subpackage Frontend
 */
class FrontControllerHandler extends \Framework\Core\Object {
	static $controllerNamespace = '';
	
	public function handleRequest($request, $response, $session) {
		$command = $this->commandFor($request);
		
		$command->initialize($request, $response, $session);
		$command->execute();
	}
	
	protected function commandFor($request) {
		return \Framework\Commands\FrontControllerCommand::commandFor(static::$controllerNamespace, $request->command());
	}
	
	public static function setControllerNamespace($namespace) {
		static::$controllerNamespace = $namespace;
	}
}

?>