<?php

namespace Framework\Views;

/**
 * @package Framework
 * @subpackage Views
 */
class BasicAuthenticateTransformView extends TransformView {
	private $realm;
	
	public function construct($realm) {
		parent::construct();
		
		$this->realm = $realm;
		
		\header('WWW-Authenticate: Basic realm="'.$this->realm.'"');
	}
	
	public function header() {
		return $_SERVER['SERVER_PROTOCOL'].' 401 Unauthorized';
	}
	
	public function content() {
		return '';
	}
}

?>