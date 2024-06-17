<?php

namespace Core\DAOs;

use Core\DAOs\ObjectRelacionalModel;

trait Entity
{
    private static ObjectRelacionalModel $orm;
    public function construct($obj, $registry = [])
    {
        self::getORM()->forEachField(function($fild, $column) use ($obj, $registry)
        {
            if (boolval($column) && isset($registry[$fild])) {
               $obj->$fild = $registry[$fild];
            }
                
        });
    }
    
}
