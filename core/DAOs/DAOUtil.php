<?php

namespace Core\DAOs;

use Core\DB\DBConnectionHolder;

class DAOUtil
{
    public static $enableTransaction = true;
    public static function buildUpdateSets($values = [], $props = [])
    {
        $acumulator = '';
        $counter = 0;
        foreach ($values as $valueKey => $value) {
            if (isset($props[$valueKey])) {
                $columnName = $props[$valueKey];
                $acumulator .= $counter == 0
                ?  "$columnName = :$valueKey"
                : ", $columnName = :$valueKey";
                $counter++;
            }
        }
        return $acumulator;
    }
    public static function buildPagination($size = 0, $number = 1)
    {
        return $size === 0 ? '' : "LIMIT $size OFFSET " . ($number - 1) * $size;
    }
    public static function beginTransactionIfEnable()
    {
        if (self::$enableTransaction) {
            DBConnectionHolder::getConnection()->beginTransaction();
        }
    }
    public static function commitIfEnable()
    {
        if (self::$enableTransaction && DBConnectionHolder::getConnection()->inTransaction()) {
            DBConnectionHolder::getConnection()->commit();
        }
    }
    public static function rollbackIfEnable()
    {
        if (self::$enableTransaction && DBConnectionHolder::getConnection()->inTransaction()) {
            DBConnectionHolder::getConnection()->rollback();
        }
    }
}
