<?php

namespace Framework\Application;

/**
 * @package Framework
 * @subpackage Application
 */
abstract class Application extends \Framework\Core\VariableSingleton {
	const Production = 0;
	const Development = 1;
	const Testing = 2;
	
	private $runMode;
	private $config;
	private $request;
	private $response;
	
	public function setRunMode($mode) {
		$this->runMode = $mode;
	}
	
	public function setUp() {
		$this->setUpWithConfiguration($this->getConfiguration());
	}
	
	public function getConfiguration() {
		switch ($this->runMode) {
			case self::Production:
				return array_merge($this->getCommonConfiguration(), $this->getProductionConfiguration());
			break;
			case self::Development:
				return array_merge($this->getCommonConfiguration(), $this->getDevelopmentConfiguration());
			break;
			case self::Testing:
				return array_merge($this->getCommonConfiguration(), $this->getTestingConfiguration());
			break;
		}
	}
	
	protected function setUpWithConfiguration($config) {
		$this->request = \Framework\Frontend\UrlRequest::instance();
		$this->response = \Framework\Frontend\Response::instance();
		
		$this->setUpSystem($config, $this->request, $this->response);
	}
	
	public function setUpSystem($config, $request, $response) {
		\Framework\Helpers\Application::initializeSystem($config, $request, $response);
		
		$this->session = \Framework\Frontend\Session::instance();
	}
	
	public function run() {
		\Framework\Frontend\FrontControllerHandler::instance()->handleRequest($this->request, $this->response, $this->session);
		
		$this->response->send();
	}
	
	abstract protected function getCommonConfiguration();
	abstract protected function getProductionConfiguration();
	abstract protected function getDevelopmentConfiguration();
	abstract protected function getTestingConfiguration();
	
	public static function applicationFor($projectName) {
		$class = $projectName.'\\Application\\Application';
		
		static::setSingletonClass($class);
		
		try {
			return static::instance();
		} catch (\Exception $e) {
			return static::nullInstance();
		}
	}
	
	public static function initializeProject($projectName, $mode) {
		$application = static::applicationFor($projectName);
		
		$application->setRunMode($mode);
		$application->setUp();
		
		return $application;
	}
}

?>