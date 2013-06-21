<?php

namespace Framework\Tests\Frontend;

/**
 * @package Framework
 * @subpackage Tests
 */

class Request extends \Framework\Testing\TestCase {
	protected function setUp() {
		$this->request = \Framework\Frontend\UrlRequest::instance();
	}
	
	public function testAssignments() {
		$get = new \ArrayObject();
		$post = new \ArrayObject();
		$files = new \ArrayObject();
		$environment = new \ArrayObject();
		
		$this->request->setGet($get);
		$this->request->setPost($post);
		$this->request->setFiles($files);
		$this->request->setEnvironment($environment);
		
		$this->assertEquals($get, $this->request->getGet());
		$this->assertEquals($post, $this->request->getPost());
		$this->assertEquals($files, $this->request->getFiles());
		$this->assertEquals($environment, $this->request->getEnvironment());
	}
	
	public function testEmptyRoute() {
		$this->request->setEnvironment(array('SCRIPT_NAME'=>'/index.php', 'REQUEST_URI' => ''));
		
		$this->assertEquals('HomepageCommand', $this->request->command());
		$this->assertEquals('index', $this->request->action());
		$this->assertNull($this->request->parameter());
	}
	
	public function testSlashRoute() {
		$this->request->setEnvironment(array('SCRIPT_NAME'=>'/index.php', 'REQUEST_URI' => '/'));
		
		$this->assertEquals('HomepageCommand', $this->request->command());
		$this->assertEquals('index', $this->request->action());
		$this->assertNull($this->request->parameter());
	}
	
	public function testIndexRoute() {
		$this->request->setEnvironment(array('SCRIPT_NAME'=>'/index.php', 'REQUEST_URI' => '/index.php'));
		
		$this->assertEquals('HomepageCommand', $this->request->command());
		$this->assertEquals('index', $this->request->action());
		$this->assertNull($this->request->parameter());
	}
	
	public function testCommandRoute() {
		$this->request->setEnvironment(array('SCRIPT_NAME'=>'/index.php', 'REQUEST_URI' => '/Account'));
		
		$this->assertEquals('AccountCommand', $this->request->command());
		$this->assertEquals('index', $this->request->action());
		$this->assertNull($this->request->parameter());
	}
	
	public function testCommandAndActionRoute() {
		$this->request->setEnvironment(array('SCRIPT_NAME'=>'/index.php', 'REQUEST_URI' => '/Account/create'));
		
		$this->assertEquals('AccountCommand', $this->request->command());
		$this->assertEquals('create', $this->request->action());
		$this->assertNull($this->request->parameter());
	}
	
	public function testFullRoute() {
		$this->request->setEnvironment(array('SCRIPT_NAME'=>'/index.php', 'REQUEST_URI' => '/Account/save/3'));
		
		$this->assertEquals('AccountCommand', $this->request->command());
		$this->assertEquals('save', $this->request->action());
		$this->assertEquals('3', $this->request->parameter());
	}
}

?>