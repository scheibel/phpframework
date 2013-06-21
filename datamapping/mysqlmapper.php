<?php

namespace Framework\Datamapping;

/**
 * @package Framework
 * @subpackage Datamapping
 */
class MySQLMapper extends \Framework\Core\Object {
	private $mysqli;
	
	public function construct($host, $username, $passwort, $database) {
		$this->mysqli = new \MySQLi($host, $username, $passwort, $database);
		
		if (!$this->mysqli) {
			throw new Exception("Not connected to MySQL server.");
		}
	}
	
	public function __call($method, $params) {
		return call_user_func_array(array($this->mysqli, $method), $params);
	}
	
	public function __set($variableName, $value) {
		$this->mysqli->$variableName = $value;
	}
	
	public function __get($variableName) {
		return $this->mysqli->$variableName;
	}
	
	public static function forProject($projectName) {
		$config = \Framework\Application\Application::instance()->getConfiguration();
		
		return static::instance($config['mysqlHost'], $config['mysqlUser'], $config['mysqlPassword'], $config['mysqlDatabase']);
	}
}

?>