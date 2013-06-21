<?php

namespace Framework\Frontend;

/**
 * @package Framework
 * @subpackage Frontend
 */
abstract class Request extends \Framework\Core\Object {
	protected $get;
	protected $post;
	protected $files;
	protected $environment;
	
	public function getGet() {
		return $this->get;
	}
	
	public function setGet($get) {
		$this->get = $get;
	}
	
	public function getPost() {
		return $this->post;
	}
	
	public function setPost($post) {
		$this->post = $post;
	}
	
	public function getFiles() {
		return $this->files;
	}
	
	public function setFiles($files) {
		$this->files = $files;
	}
	
	public function getEnvironment() {
		return $this->environment;
	}
	
	public function setEnvironment($environment) {
		$this->environment = $environment;
	}
	
	abstract public function command();
	abstract public function action();
	abstract public function parameter();
}

?>