<?php

namespace Framework\Datamapping;

/**
 * @package Framework
 * @subpackage Datamapping
 */
class LazyModelWrapper extends \Framework\Core\LazyWrapper {
	private $id;
	
	public function construct($function, $id) {
		parent::construct($function);
		
		$this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}
}

?>