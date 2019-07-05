<?php
declare (strict_types = 1);

namespace MStroink\Solax\Tests\Resource\RealTime;

use MStroink\Solax\Tests\TestBase;
use MStroink\Solax\Resource\RealTime\Pv;

class PvTest extends TestBase
{
    public function testCreate()
    {
        /**
         * @var \MStroink\Solax\Resource\RealTime\Pv $rt
         */
        $pv = Pv::create($this->fixture('RealTimeData.json')['Data']);
        $this->assertSame(2.2, $pv->getPv1Current());
        $this->assertSame(0.0, $pv->getPv2Current());
        $this->assertSame(384.1, $pv->getPv1Voltage());
        $this->assertSame(0.0, $pv->getPv2Voltage());
        $this->assertSame(870, $pv->getPv1Power());
        $this->assertSame(0, $pv->getPv2Power());
    }

    public function testToArray()
    {
        $pv = Pv::create($this->fixture('RealTimeData.json')['Data']);
        $this->assertCount(6, $pv->toArray());
    }
}
