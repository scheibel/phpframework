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
		return $this->editViewOf($this->modelInstance(), 0);
	}
	
	public function edit($id) {
		return $this->editViewOf($this->mapperInstance()->get($id), $id);
	}
	
	public function save() {
		$post = $this->preparsePost($this->request()->getPost());
		
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
		
		$this->redirectTo($this->indexUrl());
	}
	
	public function delete($id) {
		$model = $this->mapperInstance()->get($id);
		
		if ($model->isNotNull()) {
			$this->beforeDelete($model);
			
			$this->mapperInstance()->delete($model);
			
			$this->deleted($model);
		}
		
		$this->redirectTo($this->indexUrl());
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
	abstract protected function editViewOf($model, $id);
	abstract protected function indexUrl();
}

?>