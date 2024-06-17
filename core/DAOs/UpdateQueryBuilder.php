<?php

namespace Core\DAOs;
use Core\DAOS\QueryBuilder;

class UpdateQueryBuilder extends QueryBuilder
{
    private array $settings = [];
    private string $tableName;
    private WhereExpression $where;
    public function __construct( ObjectRelacionalModel $model)
    {
        parent::__construct($model);
        $this->tableName = $model->getTable();
    }
    public function addSetting(string $field): UpdateQueryBuilder
    {
        $obj = $this->model->getField($field);

        $this->settings[] = new WhereExpression(
            WhereExpression::EQUAL,
            $obj['column'],
            ':' . $obj['field']
        );
        return $this;
    }
    public function addCondition(WhereExpression $condition): UpdateQueryBuilder
    {
        if (isset($this->where)) {
            $this->where = new WhereExpression(
                WhereExpression::LOGIC_AND,
                $this->where,
                $condition
            );
        } else {
            $this->where = $condition;
        }
        return $this;
    }
    public function byField(string $field): UpdateQueryBuilder
    {
        $fieldval = $this->model->getField($field);            
        $condition =  new WhereExpression(WhereExpression::EQUAL, $fieldval['column'],":$field");
        $this->where = isset($this->where)
            ? $this->where->and($condition)
            : $condition;
        return $this;
    }
    public function byFieldLike(string $field): UpdateQueryBuilder
    {
        $fieldval = $this->model->getField($field);            
        $condition =  new WhereExpression(WhereExpression::LIKE, $fieldval['column'],":$field");
        $this->where = isset($this->where)
            ? $this->where->and($condition)
            : $condition;
        return $this;
    }

    public function byId(): UpdateQueryBuilder
    {
        $id = $this->model->getPrimaryKey();
        if (!is_array($id)) {
            $id = [$id];
        }
        foreach ($id as $ob) {
            $field = $ob['field'];
            $condition =  new WhereExpression(WhereExpression::EQUAL, $ob['column'],":$field");
            $this->where = isset($this->where)
                ? $this->where->and($condition)
                : $condition;
        }
        return $this;     
    }
    public function __toString(): string
    {
        $where = '';
        if (isset($this->where)) {
            $where =  ' WHERE ' . $this->where; 
        }
        return 'UPDATE ' . $this->tableName
            . ' SET ' . join(', ', $this->settings) 
            . $where;
    }

}
