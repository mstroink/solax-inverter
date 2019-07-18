<?php

declare(strict_types=1);

namespace MStroink\Solax\Tests\Resource\RealTime;

use MStroink\Solax\Tests\TestBase;
use MStroink\Solax\Resource\RealTime\Meta;

class MetaTest extends TestBase
{
    public function testCreate()
    {
        /**
         * @var \MStroink\Solax\Resource\RealTime\Meta $meta
         */
        $meta = Meta::create($this->fixture('RealTimeData.json'));
        $this->assertSame('uploadsn', $meta->getMethod());
        $this->assertSame('Solax_SI_CH_2nd_11111111_XX11', $meta->getVersion());
        $this->assertSame('AL_SI', $meta->getType());
        $this->assertSame('XX1X11X1', $meta->getSerialNumber());
        $this->assertSame(2, $meta->getStatus());
    }

    public function testToArray()
    {
        $meta = Meta::create($this->fixture('RealTimeData.json'));
        $this->assertCount(5, $meta->toArray());
    }
}
