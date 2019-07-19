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

    public function testCreateWithBattery()
    {
        /**
         * @var \MStroink\Solax\Resource\RealTime\Battery $battery
         */
        $battery = Battery::create($this->fixture('RealTimeDataWithBattery.json')['Data']);
        $this->assertSame(-39.35, $battery->getCurrent());
        $this->assertSame(48.89, $battery->getVoltage());
        $this->assertSame(-1945.9, $battery->getPower());
        $this->assertSame(23.0, $battery->getRemainCapacity());
        $this->assertSame(5.0, $battery->getTemperature());
    }

    public function testToArray()
    {
        $battery = Battery::create($this->fixture('RealTimeDataWithBattery.json')['Data']);
        $this->assertCount(5, $battery->toArray());
    }
}
