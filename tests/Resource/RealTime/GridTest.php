<?php

declare(strict_types=1);

namespace MStroink\Solax\Tests\Resource\RealTime;

use MStroink\Solax\Tests\TestBase;
use MStroink\Solax\Resource\RealTime\Grid;

class GridTest extends TestBase
{
    public function testCreate()
    {
        /**
         * @var \MStroink\Solax\Resource\RealTime\Grid $grid
         */
        $grid = Grid::create($this->fixture('RealTimeData.json')['Data']);
        $this->assertSame(3.3, $grid->getCurrent());
        $this->assertSame(240.4, $grid->getVoltage());
        $this->assertSame(798, $grid->getPower());
        $this->assertSame(0, $grid->getFeedInPower());
        $this->assertSame(49.99, $grid->getFrequency());
        $this->assertSame(0.0, $grid->getExported());
        $this->assertSame(0.0, $grid->getImported());
    }

    public function testToArray()
    {
        $grid = Grid::create($this->fixture('RealTimeData.json')['Data']);
        $this->assertCount(7, $grid->toArray());
    }
}
