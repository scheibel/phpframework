<?php

namespace Framework\Testing;

/**
 * @package Framework
 * @subpackage Testing
 */

class Factory extends \Framework\Core\Singleton {
	public function getInstance($instance) {
		$class = array_pop(explode("\\", get_called_class()));
		
		return $this->getFactory($class, $instance);
	}
	
	public function getFactory($class, $instance) {
		$project = array_shift(explode("\\", get_called_class()));
		
		return $this->getCompleteFactory($project, $class, $instance);
	}
	
	public function getCompleteFactory($project, $class, $instance) {
		$className = "\\".$project."\\Tests\\Factories\\".$class;
		
		return $className::instance()->perform("get".$instance);
	}
}

?>