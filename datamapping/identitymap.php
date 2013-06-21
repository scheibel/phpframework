<?php

namespace Framework\Datamapping;

/**
 * @package Framework
 * @subpackage Datamapping
 */

class IdentityMap extends \Framework\Core\Object {
	private $identities;
	
	public function construct() {
		$this->identities = new \ArrayObject();
	}
	
	public function has($id) {
		return isset($this->identities[$id]);
	}
	
	public function hasObject($object) {
		return false !== $this->idOf($object);
	}
	
	public function get($id) {
		return $this->identities[$id];
	}
	
	public function idOf($object) {
		if ($object->isWrapper() && $object->__isWrapped()) {
			return $object->getId();
		}
		
		foreach ($this->identities as $id=>$element) {
			if ($object->equals($element)) {
				return $id;
			}
		}
		
		return false;
	}
	
	public function register($id, $object) {
		$this->identities[$id] = $object;
	}
	
	public function unregister($object) {
		$id = $this->idOf($object);
		
		if ($id) {
			unset($this->identities[$id]);
		}
	}
}

?>