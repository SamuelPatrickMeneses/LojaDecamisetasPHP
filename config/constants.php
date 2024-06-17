<?php
define('ROOT_PATH', dirname(__DIR__));
define('YEAR_TIME', 31536000000);
function nop() // not operarion function, for callbacks defalt value.
{}
function is_int_string($val)
{
    return filter_var($val, FILTER_VALIDATE_INT);
}
function is_float_string($val)
{
    return filter_var($val, FILTER_VALIDATE_FLOAT);
}
