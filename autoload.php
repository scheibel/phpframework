<?php

if (isset($_SERVER['TASTEFUL_REVOLUTION_PROJECT'])) {
	$basename = $_SERVER['TASTEFUL_REVOLUTION_PROJECT']."/";
	
	spl_autoload_register(function ($namespacedClassName) use ($basename) {
		$parts = preg_split('/\\\\/', $namespacedClassName);
		
		$classname = array_pop($parts);
		
		$parts = array_map(function($elem) {
			return preg_replace('/([a-z])([A-Z])/', '$1 $2', $elem);
		}, $parts);
		
		array_push($parts, $classname);
		
		$file = strtolower(implode("/", $parts)).".php";
		
		if (substr($file, 0, strlen($basename)) == $basename) {
			$file = substr($file, strlen($basename));
		} else {
			$file = dirname(dirname(__FILE__))."/".$file;
		}
		
		if (file_exists($file)) {
			require_once($file);
		} else {
			die("Tried to load ".$namespacedClassName."\nFile not found: ".$file."\n");
		}
	});
} else {
	spl_autoload_register(function ($namespacedClassName) {
		$parts = preg_split('/\\\\/', $namespacedClassName);
		
		$classname = array_pop($parts);
		
		$parts = array_map(function($elem) {
			return preg_replace('/([a-z])([A-Z])/', '$1 $2', $elem);
		}, $parts);
		
		array_push($parts, $classname);
		
		$file = $file = dirname(dirname(__FILE__))."/".strtolower(implode("/", $parts)).".php";
		
		if (file_exists($file)) {
			require_once($file);
		} else {
			die("Tried to load ".$namespacedClassName."\nFile not found: ".$file."\n");
		}
	});
}

?>