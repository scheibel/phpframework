<?php

namespace Framework\Datamapping;

/**
 * @package Framework
 * @subpackage Datamapping
 */

class SavingSemaphore extends \Framework\Core\Singleton {
	private $owner;
	private $saved;
	
	public function construct() {
		$this->deactivate();
	}
	
	public function addSaved($model) {
		$this->saved->add($model);
	}
	
	public function isSaved($model) {
		return $this->saved->includes($model);
	}
	
	public function activate($owner) {
		$this->owner = $owner;
	}
	
	public function deactivate() {
		$this->owner = \Framework\Core\Object::nullInstance();
		$this->saved = \Framework\Core\Set::instance();
	}
	
	public function isActive() {
		return $this->owner->isNotNull();
	}
	
	public function getOwner() {
		return $this->owner;
	}
	
	public function execute($owner, $function) {
		if ($this->isActive()) {
			$function($owner, $this);
		} else {
			$this->activate($owner);
			
			$function($owner, $this);
			
			$this->deactivate();
		}
	}
}

?>