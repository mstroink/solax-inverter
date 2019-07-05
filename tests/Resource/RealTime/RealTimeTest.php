<?php
declare (strict_types = 1);

namespace MStroink\Solax\Tests\Resource\RealTime;

use MStroink\Solax\Tests\TestBase;
use MStroink\Solax\Resource\RealTime\RealTime;
use MStroink\Solax\Resource\RealTime\Meta;
use MStroink\Solax\Resource\RealTime\Pv;
use MStroink\Solax\Resource\RealTime\Grid;
use MStroink\Solax\Resource\RealTime\Inverter;

class RealTimeTest extends TestBase
{
    public function testCreate()
    {
        /**
         * @var \MStroink\Solax\Resource\RealTime\Realtime $rt
         */
        $rt = RealTime::create($this->fixture('RealTimeData.json'));
        $this->assertInstanceOf(Meta::class, $rt->Meta);
        $this->assertInstanceOf(Pv::class, $rt->Pv);
        $this->assertInstanceOf(Grid::class, $rt->Grid);
        $this->assertInstanceOf(Inverter::class, $rt->Inverter);
        $this->assertNull($rt->Battery);
    }

    public function testToArray()
    {
        $rt = RealTime::create($this->fixture('RealTimeData.json'));
        $this->assertCount(5, $rt->toArray());
        $this->assertInternalType('array', $rt->toArray());
    }
}
