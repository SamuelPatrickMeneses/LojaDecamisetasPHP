<?php

namespace Core\DAOs;
use Core\DAOS\QueryBuilder;
use Core\DAOS\SelectExpression;

class SelectQueryBuilder extends QueryBuilder
{
    private array $exprecions = [];
    private string $tableName;
    private WhereExpression $where;
    private PaginationExpression $pagination;
    public function __construct( ObjectRelacionalModel $model)
    {
        parent::__construct($model);
        $this->tableName = $model->getTable();
        $this->pagination = new PaginationExpression();
    }
    public function setPagination(PaginationExpression $pagination)
    {
        $this->pagination = $pagination;
        return $this;
    }
    public function addExprecion(SelectExpression $exprecion): SelectQueryBuilder
    {
        $this->exprecions[] = $exprecion;
        return $this;
    }
    public function addCondition(WhereExpression $condition): SelectQueryBuilder
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
    public function byField(string $field)
    {
        $fieldval = $this->model->getField($field);            
        $condition =  new WhereExpression(WhereExpression::EQUAL, $fieldval['column'],":$field");
        $this->where = isset($this->where)
            ? $this->where->and($condition)
            : $condition;
        return $this;
    }
    public function byFieldLike(string $field)
    {
        $fieldval = $this->model->getField($field);            
        $condition =  new WhereExpression(WhereExpression::LIKE, $fieldval['column'],":$field");
        $this->where = isset($this->where)
            ? $this->where->and($condition)
            : $condition;
        return $this;
    }

    public function byId(): SelectQueryBuilder
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
    public function ByFields($fields)
    {
        $obj = $this;
        $this->model->forEachField(function($field, $column) use($obj, $fields)
        {
            if ($column && isset($fields[$field])) {
                $obj->byField($field);
            }
        });

    }
    public function ByFieldsLike($fields)
    {
        $obj = $this;
        $this->model->forEachField(function($field, $column) use($obj, $fields)
        {
            if ($column && isset($fields[$field])) {
                $obj->byField($field);
            }
        });

    }
    public function __toString(): string
    {
        $where = '';
        if (isset($this->where)) {
            $where =  ' WHERE ' . $this->where; 
        }
        return 'SELECT ' . join(', ', $this->exprecions) 
            . ' FROM ' . $this->tableName
            . $where . $this->pagination;
    }

}
