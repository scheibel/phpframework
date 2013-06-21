<?php

namespace Framework\Datamapping;

/**
 * @package Framework
 * @subpackage Datamapping
 */
class LazyModelsWrapper extends \Framework\Core\LazyWrapper implements \IteratorAggregate, \Countable {
	public function getIterator() {
		$this->__ensureWrappee();
		
		return $this->__getWrappee()->getIterator();
	}
	
	public function count() {
		$this->__ensureWrappee();
		
		return $this->__getWrappee()->count();
	}
}

?>