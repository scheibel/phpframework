<?php

namespace Framework\Frontend;

/**
 * @package Framework
 * @subpackage Frontend
 */
class UrlRequest extends Request {
	public function command() {
		$ressourceParts = $this->routeParts();
		
		return isset($ressourceParts[0])?$ressourceParts[0]:null;
	}
	
	public function action() {
		$ressourceParts = $this->routeParts();
		
		return isset($ressourceParts[1])?$ressourceParts[1]:null;
	}
	
	public function parameter() {
		$ressourceParts = $this->routeParts();
		
		return isset($ressourceParts[2])?$ressourceParts[2]:null;
	}
	
	public function routeParts() {
		$route = $this->route();
		
		if ($route=='') {
			return array('HomepageCommand', 'index');
		}
		
		if (substr($route, 0, 9) == 'index.php') {
			return array("HomepageCommand", "index");
		}
		
		if (($pos = strpos($route, "?"))!==false) {
			$route = substr($route, 0, $pos);
		}
		
		if (($pos = strpos($route, "#"))!==false) {
			$route = substr($route, 0, $pos);
		}
		
		$parts = explode("/", $route, 3);
		
		switch (count($parts)) {
			case 1:
				return array($parts[0]?$parts[0]."Command":"HomepageCommand", "index");
			break;
			case 2:
				return array($parts[0]."Command", $parts[1]?:"index");
			break;
			default:
				return array($parts[0]."Command", $parts[1], $parts[2]?:0);
			break;
		}
	}
	
	public function route() {
		$dirname = dirname($this->environment['SCRIPT_NAME']);
		
		if ($dirname == '/') {
			$dirname = '';
		}
		
		return (string)substr($this->environment['REQUEST_URI'], strlen($dirname)+1);
	}
}

?>