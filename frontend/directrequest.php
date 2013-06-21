<?php

namespace Framework\Frontend;

/**
 * @package Framework
 * @subpackage Frontend
 */
class DirectRequest extends Request {
	private $command;
	private $action;
	private $parameter;
	
	public function getCommand() {
		return $this->command;
	}
	
	public function setCommand($command) {
		$this->command = $command;
	}
	
	public function getAction() {
		return $this->action;
	}
	
	public function setAction($action) {
		$this->action = $action;
	}
	
	public function getParameter() {
		return $this->parameter;
	}
	
	public function setParameter($parameter) {
		$this->parameter = $parameter;
	}
	
	public function command() {
		return $this->command;
	}
	
	public function action() {
		return $this->action;
	}
	
	public function parameter() {
		return $this->parameter;
	}
}

?>