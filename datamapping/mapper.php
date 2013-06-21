<?php

namespace Framework\Datamapping;

/**
 * @package Framework
 * @subpackage Datamapping
 */

abstract class Mapper extends \Framework\Core\Singleton {
	protected function modelInstance() {
		$class = $this->modelClass();
		
		return $class::instance();
	}
	
	protected function modelNullInstance() {
		$class = $this->modelClass();
		
		return $class::nullInstance();
	}
	
	abstract protected function modelClass();
	abstract public function buildFromRecord($model, $record);
	abstract protected function buildRecordFrom($model);
}

?>