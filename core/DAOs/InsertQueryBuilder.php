<?php

namespace Core\DAOs;
use Core\DAOS\QueryBuilder;

class InsertQueryBuilder extends QueryBuilder
{
    private string $tableName;
    private array $columns = [];
    private array $fields = [];
    public function __construct( ObjectRelacionalModel $model)
    {
        parent::__construct($model);
        $this->tableName = $model->getTable();
    }
    public function addColumn(string $column, string $field): InsertQueryBuilder
    {
        $this->columns[] = $column;
        $this->fields[] = $field;
        return $this;
    }
    public function __toString(): string
    {
        return 'INSERT INTO '. $this->tableName 
            . ' ('. join(', ', $this->columns) 
            . ') VALUES (:' . join(', :', $this->fields) . ')';
    }

}
