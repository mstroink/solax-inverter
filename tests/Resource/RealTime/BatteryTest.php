<?php

declare(strict_types=1);

namespace MStroink\Solax\Tests\Resource\RealTime;

use MStroink\Solax\Tests\TestBase;
use MStroink\Solax\Resource\RealTime\Battery;
use MStroink\Solax\Exception\CreatableException;

class BatteryTest extends TestBase
{
    public function testCreate()
    {
        $this->expectException(CreatableException::class);
        Battery::create($this->fixture('RealTimeData.json')['Data']);
    }
}
