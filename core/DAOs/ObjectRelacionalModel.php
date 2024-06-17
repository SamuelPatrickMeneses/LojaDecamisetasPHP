<?php

namespace Core\DAOs;

use Error;

class ObjectRelacionalModel
{
    private $fields = [];
    private $columns = [];
    private array $primareKey = [];
    public function __construct(private string $class, private string $table)
    {
    }
    public function add(string $field, string $column = null, array $obj = []): ObjectRelacionalModel
    {
        $propert = [
            "field" => $field,
        ];
        if ($column != null) {
            $propert['column'] = $column;
        }
        $propert = array_merge($propert, $obj);
        $this->fields[$field] = $propert;
        $this->columns[$column] = $propert;
        return $this;
    }
    public function setPrimaryKey(string $primary): ObjectRelacionalModel
    {
        if (!isset($this->columns[$primary])) {
            throw new Error('this column is indefined');
        }
        $column = $this->columns[$primary];
        $column['pk'] = true;
        $this->fields[$column['field']] = $column;
        $this->primareKey[] = $column;
        return $this;
    }
    public function getField(string $field)
    {
        if (!isset($this->fields[$field])) {
            throw new Error("this field don't exists ($field)");
        }
        return $this->fields[$field];
    }
    public function getColumn(string $column)
    {
        if (!isset($this->columns[$column])) {
            throw new Error("this column don't exists ($column)");
        }
        return $this->columns[$column];
    }
    public function forEachField($function)
    {
        foreach ($this->fields as $field => $ob) {
            $function(
                $field, 
                isset($ob['column']) 
                    ? $ob['column']
                    : false,
                $ob
            );
        }
    }
    public function forEachIds($function)
    {
        foreach ($this->primareKey as  $obj) {
            $function(
                $obj['field'], 
                isset($obj['column']) 
                    ? $obj['column']
                    : false,
                $obj
            );
        }
    }
    public function getTable(): string
    {
        return $this->table;
    }
    public function getPrimaryKey()
    {
        return $this->primareKey;
    }
    public function getClass()
    {
        return $this->class;
    }
}
