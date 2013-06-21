<?php

namespace Framework\Frontend;

/**
 * @package Framework
 * @subpackage Frontend
 */
class Response extends \Framework\Core\Object {
	private $header;
	private $contentHolder;
	
	public function getHeader() {
		return $this->header;
	}
	
	public function setHeader($header) {
		$this->header = $header;
	}
	
	public function getContent() {
		return $this->contentHolder;
	}
	
	public function setContent($contentHolder) {
		$this->contentHolder = $contentHolder;
	}
	
	public function sendContent() {
		if ($this->contentHolder instanceof \Framework\Core\Object) {
			echo $this->contentHolder->content();
		}else{
			echo (string)$this->contentHolder;
		}
	}
	
	public function sendHeader() {
		if ($this->header) {
			if (headers_sent()) {
				throw new \Exception('Headers already been sent.');
			}else{
				header($this->header);
			}
		}
	}
	
	public function send() {
		try {
			$exception = null;
			
			$this->sendHeader();
		} catch (\Exception $e) {
			$exception = $e;
		}
		
		$this->sendContent();
		
		if ($exception) {
			throw $exception;
		}
	}
}

?>