<?php

namespace Core\DAOs;
use Core\DAOS\QueryBuilder;

class DeleteQueryBuilder extends QueryBuilder
{
    private string $tableName;
    private WhereExpression $where;
    public function __construct( ObjectRelacionalModel $model)
    {
        parent::__construct($model);
        $this->tableName = $model->getTable();
    }
    public function addCondition(WhereExpression $condition): DeleteQueryBuilder
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
    public function byField(string $fild)
    {
        $fildval = $this->model->getField($fild);            
        $condition =  new WhereExpression(WhereExpression::EQUAL, $fildval['column'],":$fild");
        $this->where = isset($this->where)
            ? $this->where->and($condition)
            : $condition;
        return $this;
    }
    public function byFieldLike(string $fild)
    {
        $fildval = $this->model->getField($fild);            
        $condition =  new WhereExpression(WhereExpression::LIKE, $fildval['column'],":$fild");
        $this->where = isset($this->where)
            ? $this->where->and($condition)
            : $condition;
        return $this;
    }

    public function byId(): DeleteQueryBuilder
    {
        $id = $this->model->getPrimaryKey();
        if (!is_array($id)) {
            $id = [$id];
        }
        foreach ($id as $ob) {
            $fild = $ob['fild'];
            $condition =  new WhereExpression(WhereExpression::EQUAL, $ob['column'],":$fild");
            $this->where = isset($this->where)
                ? $this->where->and($condition)
                : $condition;
        }
        return $this;     
    }
    public function ByFields($filds)
    {
        $obj = $this;
        $this->model->forEachField(function($fild, $column) use($obj, $filds)
        {
            if ($column && isset($filds[$fild])) {
                $obj->byField($fild);
            }
        });

    }
    public function ByFieldsLike($filds)
    {
        $obj = $this;
        $this->model->forEachField(function($fild, $column) use($obj, $filds)
        {
            if ($column && isset($filds[$fild])) {
                $obj->byField($fild);
            }
        });

    }
    public function __toString(): string
    {
        $where = '';
        if (isset($this->where)) {
            $where =  ' WHERE ' . $this->where; 
        }
        return 'DELETE FROM ' . $this->tableName . $where;
    }

}
