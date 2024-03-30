<?php

namespace Core;

class TimeUtil
{
    public static function dateTimeToTime(string $timestamp): int
    {
        [$date, $time] = explode(' ', $timestamp);
        [$yar, $month, $day] = explode('-', $date);
        [$hour, $minut, $second] = explode(':', $time);
        return mktime($hour, $minut, $second, $month, $day, $yar);
    }
    public static function toDateTime(int $time): string
    {
        return gmdate('Y-m-d H:i:s', $time);
    }
    public static function now(): int
    {
        return TimeUtil::dateTimeToTime(gmdate('Y-m-d H:i:s'));
    }
}
