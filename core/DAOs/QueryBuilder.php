<?php

namespace Core\DAOs;
use Core\DAOs\SelectQueryBuilder;
class QueryBuilder
{
    protected function __construct(protected ObjectRelacionalModel $model)
    {}
    public static function find(ObjectRelacionalModel $model): SelectQueryBuilder
    {
        $builder = new SelectQueryBuilder($model);
        $model->forEachField(function($field, $column) use ($builder)
        {
            if ($column ) {
                 $builder->addExprecion(new SelectExpression($column, $field));
            }
        });
        return $builder;
    }
    public static function count(ObjectRelacionalModel $model): SelectQueryBuilder
    {
        $builder = new SelectQueryBuilder($model);
        $builder->addExprecion(new SelectExpression('COUNT(*)', 'count'));
        return $builder;
    }
    public static function insert(ObjectRelacionalModel $model): InsertQueryBuilder
    {
        $builder = new InsertQueryBuilder($model);
        $model->forEachField(function($field, $column, $obj) use ($builder)
        {
            if ($column && !isset($obj['increment'])) {
                 $builder->addColumn($column, $field);
            }
        });
        return $builder;

    }
    public static function insertAll(ObjectRelacionalModel $model): InsertQueryBuilder
    {
        $builder = new InsertQueryBuilder($model);
        $model->forEachField(function($field, $column) use ($builder)
        {
            if ($column) {
                 $builder->addColumn($column, $field);
            }
        });
        return $builder;

    }
    public static function delete(ObjectRelacionalModel $model)
    {
        return new DeleteQueryBuilder($model);
    } 
    public static function update(ObjectRelacionalModel $model)
    {
        return new UpdateQueryBuilder($model);
    } 
}
