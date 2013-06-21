<?php

namespace Framework\Security;

/**
 * @package Framework
 * @subpackage Security;
 */
class NullAccessControlStrategy extends AccessControlStrategy {
	public function isAuthorized($command) {
		return true;
	}
	
	public function handleUnauthorizedAction($command) {
		
	}
}

?>