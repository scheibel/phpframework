<?php

namespace Framework\Tests\Frontend;

/**
 * @package Framework
 * @subpackage Tests
 */

class Response extends \Framework\Testing\TestCase {
	protected function setUp() {
		$this->response = \Framework\Frontend\Response::instance();
	}
	
	public function testEmptyResponse() {
		$this->assertNull($this->response->getHeader());
		$this->assertNull($this->response->getContent());
	}
	
	public function testAssignments() {
		$header = \Framework\Tests\Stubs\ResponseHeader::instance();
		$contentHolder = \Framework\Tests\Stubs\ResponseContent::instance();
		
		$this->response->setHeader($header);
		$this->response->setContent($contentHolder);
		
		$this->assert($header->equals($this->response->getHeader()));
		$this->assert($contentHolder->equals($this->response->getContent()));
	}
	
	public function testEmptyContentSending() {
		$this->expectOutputString('');
		
		$this->response->send();
	}
	
	public function testEmptyHeaderSending() {
		$this->expectOutputString('Hello, world!');
		
		$this->response->setContent(\Framework\Tests\Stubs\ContentHolder::instance());
		
		$this->response->send();
	}
	
	public function testSending() {
		$this->expectOutputString('Hello, world!');
		
		$this->response->setContent(\Framework\Tests\Stubs\ContentHolder::instance());
		$this->response->setHeader("Location: index.php");
		
		try {
			$this->response->send();
		} catch (Exception $e) {
			// Can't test real header sending due to PHPUnit
		}
	}
}

?>