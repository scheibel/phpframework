<?php

namespace Framework\Commands;

/**
 * @package Framework
 * @subpackage Commands
 */
abstract class FrontControllerCommand extends \Framework\Core\Object {
	private $accessControl;
	private $request;
	private $response;
	private $session;
	
	public static function commandFor($namespace, $command) {
		$command = $namespace.'\\'.$command;
		try {
			return $command::instance();
		} catch (Exception $e) {
			return static::nullInstance();
		}
	}
	
	public function initialize($request, $response, $session) {
		$this->request = $request;
		$this->response = $response;
		$this->session = $session;
		
		$this->accessControl = static::accessControlStrategy();
	}
	
	public function execute() {
		$transformView = $this->executeAction();
		
		$transformView->setRequest($this->request);
		$transformView->setSession($this->session);
		
		$this->response->setHeader($transformView->header());
		$this->response->setContent($transformView->content());
	}
	
	protected function executeAction() {
		if ($this->accessControl->isAuthorized($this)) {
			return $this->perform($this->request->action(), $this->request->parameter());
		} else {
			return $this->accessControl->handleUnauthorizedAction($this);
		}
	}
	
	public function redirectTo($url) {
		header("Location: ".$url);
		exit();
	}
	
	public function request() {
		return $this->request;
	}
	
	public function response() {
		return $this->response;
	}
	
	public function session() {
		return $this->session;
	}
	
	protected static function accessControlStrategy() {
		return \Framework\Security\NullAccessControlStrategy::instance();
	}
	
	public static function nullInstanceClass() {
		return __namespace__.'\UnknownCommand';
	}
}

?>