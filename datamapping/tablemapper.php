<?php

namespace Framework\Datamapping;

/**
 * @package Framework
 * @subpackage Datamapping
 */

abstract class TableMapper extends Mapper {
	protected $identityMap;
	protected $database;
	
	public function construct() {
		$this->identityMap = IdentityMap::instance();
		$this->database = MySQLMapperRegistry::instance()->getMySQLMapper(static::projectName());
		
		$this->identityMap->register(0, $this->modelNullInstance());
	}
	
	public function getMapper() {
		return $this->database;
	}
	
	public function idOf($model) {
		return $this->identityMap->idOf($model);
	}
	
	public function find($whereClause) {
		$_this = $this;
		
		return LazyModelsWrapper::instance(function() use ($_this, $whereClause) {
			return $_this->basicFind($whereClause);
		});
	}
	
	public function load($sql) {
		$_this = $this;
		
		return LazyModelsWrapper::instance(function() use ($_this, $sql) {
			return $_this->basicLoad($sql);
		});
	}
	
	public function basicFind($whereClause) {
		return $this->basicLoad($this->findByWhereClauseSql($whereClause));
	}
	
	public function getBy($whereClause) {
		$sql = $this->findByWhereClauseSql($whereClause." LIMIT 1");
		
		$results = $this->basicLoad($sql);
		
		if ($results->size() >= 1) {
			return $results[0];
		}
		
		return $this->modelNullInstance();
	}
	
	public function basicLoad($sql) {
		$result = $this->database->query($sql);
		
		if (!$result) {
			die($sql);
		}
		
		$results = \Framework\Core\OrderedCollection::instance();
		
		while ($record = $result->fetch_assoc()) {
			if ($this->identityMap->has($record['id'])) {
				$results->add($this->identityMap->get($record['id']));
			} else {
				$model = $this->modelInstance();
				
				$this->identityMap->register($record['id'], $model);
				
				$this->buildFromRecord($model, $record);
				
				$results->add($model);
			}
		}
		
		return $results;
	}
	
	public function get($id) {
		$_this = $this;
		
		return LazyModelWrapper::instance(function() use ($_this, $id) {
			return $_this->basicGet($id);
		}, $id);
	}
	
	public function basicGet($id) {
		if ($this->identityMap->has($id)) {
			return $this->identityMap->get($id);
		} else {
			$sql = $this->findByIdSql($id);
			
			$result = $this->database->query($sql);
			
			if ($result && $result->num_rows >= 1) {
				$model = $this->modelInstance();
				
				$this->register($id, $model);
				
				$this->buildFromRecord($model, $result->fetch_assoc());
			}else{
				$model = $this->modelNullInstance();
			}
			
			return $model;
		}
	}
	
	public function saveReturningId($model) {
		$this->save($model);
		
		return $this->identityMap->idOf($model);
	}
	
	public function save($model) {
		if ($model->isWrapper()) {
			if ($model->__isWrapped()) {
				$model = $model->__getWrappee();
			} else {
				return;
			}
		}
		
		if ($model->isNull() || SavingSemaphore::instance()->isSaved($model)) {
			return;
		}
		
		$_this = $this;
		
		SavingSemaphore::instance()->execute($model, function($model, $semaphore) use ($_this) {
			$semaphore->addSaved($model);
			
			$_this->store($model);
		});
	}
	
	public function store($model) {
		if ($this->identityMap->hasObject($model)) {
			$sql = $this->updateByIdSql($model, $this->identityMap->idOf($model));
			
			$this->database->query($sql);
		} else {
			$sql = $this->createSql($model);
			
			$this->database->query($sql);
			
			if ($this->database->insert_id) {
				$this->register($this->database->insert_id, $model);
			}
		}
		
		$this->saveRelationsOf($model);
	}
	
	public function averageOf($field, $whereClause = '1') {
		return $this->aggregateOf($field, "AVG", $whereClause);
	}
	
	public function minOf($field, $whereClause = '1') {
		return $this->aggregateOf($field, "MIN", $whereClause);
	}
	
	public function maxOf($field, $whereClause = '1') {
		return $this->aggregateOf($field, "MAX", $whereClause);
	}
	
	public function countOf($field, $whereClause = '1') {
		return $this->aggregateOf($field, "COUNT", $whereClause.($field == '*' ?"":" GROUP BY ".$field));
	}
	
	protected function aggregateOf($field, $aggregationType, $whereClause) {
		$sql = "SELECT ".$aggregationType."(".$field.") as aggregation FROM ".$this->table()." WHERE ".$whereClause;
		
		$result = $this->database->query($sql);
		
		if ($result && $result->num_rows >= 1) {
			$row = $result->fetch_assoc();
			
			return $row['aggregation'];
		}
		
		return null;
	}
	
	protected function saveRelationsOf($model) {
		
	}
	
	protected function saveRelations($models, $mapper, $foreignKey, $foreignId) {
		if ($models->isWrapper()) {
			if ($models->__isWrapped()) {
				$models = $models->__getWrappee();
			} else {
				return;
			}
		}
		
		$ids = array();
		foreach ($models as $model) {
			$ids[] = $mapper->saveReturningId($model);
		}
		
		$array = implode(", ", array_merge(array(0), $ids));
		
		$sql = "UPDATE ".$mapper->table()." SET ".$foreignKey."=".$foreignId."*(id IN (".$array.")) WHERE ".$foreignKey."=".$foreignId." OR id IN (".$array.")";
		
		$this->database->query($sql);
	}
	
	public function delete($model) {
		$id = $this->identityMap->idOf($model);
		
		if ($id>0) {
			$sql = $this->deleteByIdSql($id);
			
			$this->database->query($sql);
			
			$this->unregister($model);
		}
	}
	
	protected function basicSelectStatement() {
		$variables = array_merge(array('id'), $this->selectVariables());
		$table = $this->table();
		
		array_walk($variables, function(&$variable) use ($table) {
			$variable = "`".$table."`.`".$variable."` AS `".$variable."`";
		});
		
		return "SELECT ".implode(", ", $variables)." FROM ".$table;
	}
	
	private function findByWhereClauseSql($whereClause) {
		return $this->basicSelectStatement()." WHERE ".$whereClause;
	}
	
	private function findByIdSql($id) {
		return $this->findByWhereClauseSql("id=".$id);
	}
	
	private function updateByIdSql($model, $id) {
		$record = $this->buildRecordFrom($model);
		
		if (count($record)) {
			return "UPDATE ".$this->table()." SET ".$this->serialize($record)." WHERE id=".$id;
		} else {
			return "SELECT 1";
		}
	}
	
	public function createSql($model) {
		$record = $this->buildRecordFrom($model);
		
		if (count($record)) {
			return "INSERT INTO ".$this->table()." SET ".$this->serialize($record);
		} else {
			return "INSERT INTO ".$this->table()." () VALUES ()";
		}
	}
	
	private function deleteByIdSql($id) {
		return "DELETE FROM ".$this->table()." WHERE id=".$id;
	}
	
	private function serialize($array) {
		$fields = array();
		
		foreach ($array as $key=>$value) {
			$fields[] = '`'.$key.'` = \''.$value.'\'';
		}
		
		return implode(", ", $fields);
	}
	
	private function register($id, $model) {
		$this->identityMap->register($id, $model);
	}
	
	private function unregister($model) {
		$this->identityMap->unregister($model);
	}
	
	abstract protected function table();
	abstract protected function selectVariables();
}

?>