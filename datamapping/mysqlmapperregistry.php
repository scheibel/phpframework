<?php

namespace Framework\Datamapping;

/**
 * @package Framework
 * @subpackage Datamapping
 */
class MySQLMapperRegistry extends \Framework\Core\Registry {
	public function getMySQLMapper($project) {
		if (!$this->hasKey($project)) {
			$this->createMapperFor($project);
		}
		
		return $this->getValue($project);
	}
	
	private function createMapperFor($project) {
		$mapper = MySQLMapper::forProject($project);
		
		$this->setValue($project, $mapper);
	}
}

?>