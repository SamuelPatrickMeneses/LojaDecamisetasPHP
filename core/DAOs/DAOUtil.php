<?php

namespace Core\DAOs;

class DAOUtil
{
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
    }
}
