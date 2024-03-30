<?php

namespace Tests;

use Core\TimeUtil;
use PHPUnit\Framework\TestCase;

class TimeUtilTest extends TestCase
{
    public function testTimestamp()
    {
        $time = mktime(2, 44, 37, 11, 19, 2001);
        $timestamp = gmdate('Y-m-d H:i:s', $time);
        $result = TimeUtil::dateTimeToTime($timestamp);
        $this->assertEquals($result, $time);
    }
}
