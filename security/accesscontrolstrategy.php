<?php

namespace Framework\Security;

/**
 * @package Framework
 * @subpackage Security;
 */
abstract class AccessControlStrategy extends \Framework\Core\Singleton {
	abstract public function isAuthorized($command);
	abstract public function handleUnauthorizedAction($command);
}

?>