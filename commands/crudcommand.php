<?php

namespace Framework\Commands;

/**
 * @package Framework
 * @subpackage Commands
 */
abstract class CrudCommand extends FrontControllerCommand {
	public function index() {
		$models = array();
		
		foreach ($this->findAll() as $model) {
			$models[$this->mapperInstance()->idOf($model)] = $model;
		}
		
		return $this->listViewOf($models);
	}
	
	public function create() {
		$get = $this->request()->getGet();
		
		return $this->editViewOf($this->modelInstance(), 0, isset($get['targetUrl']) ? $get['targetUrl'] : $this->indexUrl());
	}
	
	public function edit($id) {
		$get = $this->request()->getGet();
		
		return $this->editViewOf($this->mapperInstance()->get($id), $id, isset($get['targetUrl']) ? $get['targetUrl'] : $this->indexUrl());
	}
	
	public function save() {
		$post = $this->preparsePost($this->request()->getPost());
		$get = $this->request()->getGet();
		
		if ($post['id']>0) {
			$model = $this->mapperInstance()->get($post['id']);
			$created = false;
		}else{
			$model = $this->modelInstance();
			$created = true;
		}
		
		if ($model->isNotNull()) {
			$this->mapperInstance()->buildFromRecord($model, $post);
			
			if ($created) {
				$this->beforeCreate($model);
			} else {
				$this->beforeUpdate($model);
			}
			
			$this->mapperInstance()->save($model);
			
			if ($created) {
				$this->created($model);
			} else {
				$this->updated($model);
			}
		}
		
		if (isset($post['targetUrl'])) {
			$this->redirectTo($post['targetUrl']);
		} else if (isset($get['targetUrl'])) {
			$this->redirectTo($get['targetUrl']);
		} else {
			$this->redirectTo($this->indexUrl());
		}
	}
	
	public function delete($id) {
		$post = $this->preparsePost($this->request()->getPost());
		$get = $this->request()->getGet();
		
		$model = $this->mapperInstance()->get($id);
		
		if ($model->isNotNull()) {
			$this->beforeDelete($model);
			
			$this->mapperInstance()->delete($model);
			
			$this->deleted($model);
		}
		
		if (isset($post['targetUrl'])) {
			$this->redirectTo($post['targetUrl']);
		} else if (isset($get['targetUrl'])) {
			$this->redirectTo($get['targetUrl']);
		} else {
			$this->redirectTo($this->indexUrl());
		}
	}
	
	protected function findAll() {
		return $this->mapperInstance()->find('1');
	}
	
	protected function preparsePost($post) {
		return $post;
	}
	
	protected function beforeCreate($model) {
		
	}
	
	protected function created($model) {
		
	}
	
	protected function beforeUpdate($model) {
		
	}
	
	protected function updated($model) {
		
	}
	
	protected function beforeDelete($model) {
		
	}
	
	protected function deleted($model) {
		
	}
	
	abstract protected function modelInstance();
	abstract protected function mapperInstance();
	abstract protected function listViewOf($models);
	abstract protected function editViewOf($model, $id, $targetUrl);
	abstract protected function indexUrl();
}

?>