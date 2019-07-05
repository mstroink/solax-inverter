<?php
declare (strict_types = 1);

namespace MStroink\Solax\Tests\Resource\History;

use MStroink\Solax\Tests\TestBase;
use MStroink\Solax\Resource\History\History;

class HistoryTest extends TestBase
{
    public function testCreate()
    {
        /**
         * @var \MStroink\Solax\Resource\RealTime\History $history
         */
        $history = History::create($this->fixture('HistoryData.json'));
        $this->assertSame(4.9, $history->getSolarToday());
        $this->assertSame(5340.7, $history->getSolarTotal());
    }

    public function testToArray()
    {
        $history = History::create($this->fixture('HistoryData.json'));
        $this->assertCount(2, $history->toArray());
    }
}
