<?php

namespace Framework\Security;

/**
 * @package Framework
 * @subpackage Security;
 */
abstract class HttpBasicAccessControlStrategy extends AccessControlStrategy {
	public function isAuthorized($command) {
		$credentials = $this->getCredentials($command->request()->getEnvironment());
		
		if (count($credentials) >= 2) {
			list ($user, $password) = $credentials;
		}
		
		return isset($user) && isset($password) && $this->isValidUser($user, $password);
	}
	
	public function handleUnauthorizedAction($command) {
		$user = $this->getUser($command->request()->getEnvironment());
		
		if (is_null($user)) {
			return \Framework\Views\BasicAuthenticateTransformView::instance($this->getRealm());
		} else {
			return \Framework\Views\ForbiddenTransformView::instance();
		}
	}
	
	protected function getCredentials($environment) {
		// FastCgi fix from http://everflux.de/php-basic-authentication-und-fastcgi-mit-apache2-498/
		if (isset($environment['Authorization']) && !empty($environment['Authorization'])) {
			list ($type, $cred) = explode(" ", $environment['Authorization']);
			
			if ($type == 'Basic') {
				return explode(":", base64_decode($cred));
			}
		} else if (isset($environment['REDIRECT_HTTP_AUTHORIZATION']) && !empty($environment['REDIRECT_HTTP_AUTHORIZATION'])) {
			list ($type, $cred) = explode(" ", $environment['REDIRECT_HTTP_AUTHORIZATION']);
			
			if ($type == 'Basic') {
				return explode(":", base64_decode($cred));
			}
		}
		
		return isset($environment['PHP_AUTH_USER']) && isset($environment['PHP_AUTH_PW']) ? array($environment['PHP_AUTH_USER'], $environment['PHP_AUTH_PW']) : array();
	}
	
	protected function getUser($environment) {
		$credentials = $this->getCredentials($environment);
		
		if (count($credentials) >= 2) {
			return $credentials[0];
		}
		
		return null;
	}
	
	protected function getPassword($environment) {
		$credentials = $this->getCredentials($environment);
		
		if (count($credentials) >= 2) {
			return $credentials[1];
		}
		
		return null;
	}
	
	abstract protected function getRealm();
	abstract protected function isValidUser($username, $password);
}

?>