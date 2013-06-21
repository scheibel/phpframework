<?php

namespace Framework\Core;

/**
 * @package Framework
 * @subpackage Core
 */

class Set extends ValuedCollection {
	public function add($object) {
		if (!$this->includes($object)) {
			$this->data[] = $object;
		}
	}
}

?>