<?php

namespace Framework\Views;

/**
 * @package Framework
 * @subpackage Views
 */
abstract class TransformView extends \Framework\Core\Object {
	private $helpers;
	private $request;
	private $session;
	
	public function construct() {
		parent::construct();
		
		$this->helpers = \Framework\Core\Set::instance();
		$this->helpers->addAll(static::getHelpers());
	}
	
	abstract public function header();
	abstract public function content();
	
	protected static function getHelpers() {
		return array();
	}
	
	public function __call($method, $arguments) {
		foreach ($this->helpers as $helper) {
			if ($helper->respondsTo($method)) {
				return $helper->performWithArgumentsArray($method, $arguments);
			}
		}
		
		throw new \Exception($method." not understood.");
	}
	
	public function setRequest($request) {
		$this->request = $request;
	}
	
	public function getRequest() {
		return $this->request;
	}
	
	public function setSession($session) {
		$this->session = $session;
	}
	
	public function getSession() {
		return $this->session;
	}
}

?>