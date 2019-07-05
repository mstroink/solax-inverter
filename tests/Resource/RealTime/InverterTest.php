<?php
declare (strict_types = 1);

namespace MStroink\Solax\Tests\Resource\RealTime;

use MStroink\Solax\Tests\TestBase;
use MStroink\Solax\Resource\RealTime\Inverter;

class InverterTest extends TestBase
{
    public function testCreate()
    {
        /**
         * @var \MStroink\Solax\Resource\RealTime\Inverter $inverter
         */
        $inverter = Inverter::create($this->fixture('RealTimeData.json')['Data']);
        $this->assertSame(36, $inverter->getInnerTemperature());
        $this->assertSame(4.8, $inverter->getYieldToday());
        $this->assertSame(5340.6, $inverter->getYieldTotal());
        $this->assertSame(0.0, $inverter->getYieldTotal2());
    }

    public function testToArray()
    {
        $inverter = Inverter::create($this->fixture('RealTimeData.json')['Data']);
        $this->assertCount(4, $inverter->toArray());
    }
}
