<?php

namespace Core\DAOs;

use Core\DB\DBConnectionHolder;
use PDO;
use PDOException;
use PDOStatement;

class BaseDAO
{
    protected PDO $pdo;

    protected function __construct(protected ObjectRelacionalModel $orm)
    {
        $this->pdo = DBConnectionHolder::getConnection();
    }
    public function new($entity, $callback = null)
    {
        $comand = QueryBuilder::insert($this->orm);
        $statement = $this->pdo->prepare($comand);
        $this->bindNew($statement, $entity);
        return $this->execute($statement, $callback);
    }
    public function count($callback = null, $pageZise = 0, $pageNumber = 1)
    {
        $comand = QueryBuilder::count($this->orm)->
            setPagination(new PaginationExpression($pageZise, $pageNumber));
        $statement = $this->pdo->prepare($comand);
        return $this->fetchCount($statement, $callback);
    }
    public function find($callback = null, $pageZise = 0, $pageNumber = 1)
    {
        $comand = QueryBuilder::find($this->orm)->
            setPagination(new PaginationExpression($pageZise, $pageNumber));
        $statement = $this->pdo->prepare(strval($comand));
        return $this->fetch($statement, $callback);
    }
    public function findByField($field, $val, $callback = null, $pageZise = 0, $pageNumber = 1)
    {
        $comand = QueryBuilder::find($this->orm)->
            byField($field)->
            setPagination(new PaginationExpression($pageZise, $pageNumber));
        $statement = $this->pdo->prepare(strval($comand));
        $statement->bindValue(':' . $field, $val);
        return $this->fetch($statement, $callback);
    }
    public function findByFields($fields, $callback = null, $pageZise = 0, $pageNumber = 1)
    {
        $comand = QueryBuilder::find($this->orm)->
            setPagination(new PaginationExpression($pageZise, $pageNumber));
        $this->orm->forEachField(function($field, $column) use($comand, $fields)
        {
            if ($column && isset($fields[$field])) {
                $comand->byField($field);
            }
        });
        $statement = $this->pdo->prepare(strval($comand));
        $this->bindValues($statement, $fields);
        return $this->fetch($statement, $callback);
    }
    public function findByFieldsLike($fields, $callback = null, $pageZise = 0, $pageNumber = 1)
    {
        $comand = QueryBuilder::find($this->orm)->
            setPagination(new PaginationExpression($pageZise, $pageNumber))->
            ByFieldsLike($fields);
        $statement = $this->pdo->prepare(strval($comand));
        $this->bindValues($statement, $fields);
        return $this->fetch($statement, $callback);
    }
    public function findByFieldLike($field, $val, $callback = null, $pageZise = 0, $pageNumber = 1)
    {
        $comand = QueryBuilder::find($this->orm)->
            byFieldLike($field)->
            setPagination(new PaginationExpression($pageZise, $pageNumber));
        $statement = $this->pdo->prepare(strval($comand));
        $statement->bindValue(':' . $field, $val);
        return $this->fetch($statement, $callback);
    }
    public function findById($id, $callback = null)
    {
        $field = $this->orm->getPrimaryKey()[0]['field'];
        $comand = QueryBuilder::find($this->orm)->
            byFieldLike($field)->
            setPagination(new PaginationExpression(size: 1, number:0));
        $statement = $this->pdo->prepare(strval($comand));
        $statement->bindValue(':' . $field, $id);
        return $this->fetchOne($statement, $callback);
    }
    public function deleteByField($field, $val, $callback = null)
    {
        $comand = QueryBuilder::delete($this->orm)->
            byField($field);
        $statement = $this->pdo->prepare(strval($comand));
        $statement->bindValue(':' . $field, $val);
        return $this->executeAndCount($statement, $callback);
        
    }
    public function deleteByFields($fields, $callback = null)
    {
        $comand = QueryBuilder::delete($this->orm)->
            byFields($fields);
        $statement = $this->pdo->prepare(strval($comand));
        $this->bindValues($statement, $fields);
        return $this->executeAndCount($statement, $callback);
        
    }
    public function deleteById($id, $callback = null)
    {
        $field = $this->orm->getPrimaryKey()[0]['field'];
        return $this->deleteByField($field, $id, $callback);
    }
    public function updateByFields($fields, $values, $callback = null)
    {
        $comand = QueryBuilder::update($this->orm);
        $this->orm->forEachField(function($field, $column) use($comand, $fields, $values)
        {
            if (isset($fields[$field])) {
                $comand->addSetting($field);
            } elseif (isset($values[$field])) {
                $comand->addCondition(new WhereExpression(
                    WhereExpression::EQUAL,
                    $column,
                    ":$field"
                ));
            }
        });
        $statement = $this->pdo->prepare($comand);
        $this->bindValues($statement, $fields);
        $this->bindValues($statement, $values);
        return $this->executeAndCount($statement, $callback);
    }
    protected function fetch(PDOStatement $statement, $callback = null)
    {
        $class = $this->orm->getClass();
        try {
            $statement->execute();
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            $entities = [];
            foreach ($rows as $row) {
                $entities[] = new $class($row);
            }
            return $entities;
        } catch (PDOException $ex) {
            if (is_callable($callback)) {
                $callback($ex);
            }
        } 
        
    }
    protected function fetchOne(PDOStatement $statement, $callback = null)
    {
        $class = $this->orm->getClass();
        try {
            $statement->execute();
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (isset($rows[0])) {
                return new $class($rows[0]);
            }
        } catch (PDOException $ex) {
            if (is_callable($callback)) {
                $callback($ex);
            }
        }
        
    }
    protected function fetchCount(PDOStatement $statement, $callback = null)
    {
        try {
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $ex) {
            if (is_callable($callback)) {
                $callback($ex);
            }
        }

    }
    protected function execute(PDOStatement $statement, $callback = null)
    {
        try {
            $statement->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $ex) {
            if (is_callable($callback)) {
                $callback($ex);
            }
        }
    }
    protected function executeAndCount(PDOStatement $statement, $callback = null)
    {
        try {
            $statement->execute();
            return $statement->rowCount();
        } catch (PDOException $ex) {
            if (is_callable($callback)) {
                $callback($ex);
            }
        }
    }
    protected function bind(PDOStatement $statement, $entity): void 
    {
        $this->orm->forEachField(
        function($field, $column) use($statement, $entity)
        {
            if ($column) {
                if (is_array($entity)) {
                    $statement->bindValue(":$field", $entity[$field]);
                } else {
                    $getMethod = 'get' . ucwords($field);
                    $statement->bindValue(":$field", $entity->$getMethod());
                }
            }
        });
    }
    protected function bindNew(PDOStatement $statement, $entity): void
    {
        $this->orm->forEachField(
        function($field, $column, $obj) use($statement, $entity)
        {
            if ($column && !isset($obj['increment'])) {
                if (is_array($entity)) {
                    $statement->bindValue(":$field", $entity[$field]);
                } else {
                    $getMethod = 'get' . ucwords($field);
                    $statement->bindValue(":$field", $entity->$getMethod());
                }
            }
        });
    }
    protected function bindValues(PDOStatement $statement, $values)
    {
        $this->orm->forEachField(
        function($field, $column) use($statement, $values)
        {
            if ($column && isset($values[$field])) {
                $statement->bindValue(":$field", $values[$field]);
            }
        });
        
    }
}
