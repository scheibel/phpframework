<?php

namespace Framework\Views;

/**
 * @package Framework
 * @subpackage Views
 */
abstract class TemplatedTransformView extends LayoutedHTMLTransformView {
	static $layoutClass = '';
	
	public function content() {
		$html = parent::content();
		
		$html = str_replace('{JAVASCRIPTS}', $this->buildJavaScripts(), $html);
		$html = str_replace('{STYLESHEETS}', $this->buildStylesheets(), $html);
		$html = str_replace('{BODY}', $this->buildContent(), $html);
		
		return $html;
	}
	
	protected function buildJavaScripts() {
		$html = '';
		
		foreach ($this->javaScripts() as $scriptSource) {
			$html .= '<script type="text/javascript" src="'.$scriptSource.'"></script>'."\n";
		}
		
		return $html;
	}
	
	protected function buildStylesheets() {
		$html = '';
		
		foreach ($this->stylesheets() as $sheetSource) {
			$html .= '<link href="'.$sheetSource.'" rel="stylesheet" />'."\n";
		}
		
		return $html;
	}
	
	protected function javaScripts() {
		return array();
	}
	
	protected function stylesheets() {
		return array();
	}
	
	protected function layoutClass() {
		return static::$layoutClass;
	}
	
	public static function setLayoutClass($class) {
		static::$layoutClass = $class;
	}
	
	abstract protected function buildContent();
}

?>