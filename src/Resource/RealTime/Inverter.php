<?php
declare (strict_types = 1);

namespace MStroink\Solax\Resource\RealTime;

use MStroink\Solax\Resource\ResourceInterface as Resource;
use MStroink\Solax\Resource\DataInterface as Data;

final class Inverter implements Resource
{
    /**
     * @var int
     */
    protected $innerTemperature;
    /**
     * @var float
     */
    protected $yieldToday;
    /**
     * @var float
     */
    protected $yieldTotal;
    /**
     * @var float
     */
    protected $yieldTotal2;

    /**
     * @param int   $temperature
     * @param float $yieldToday
     * @param float $yieldTotal
     * @param float $yieldTotal2
     */
    public function __construct(
        int $temperature,
        float $yieldToday,
        float $yieldTotal,
        float $yieldTotal2
    ) {
        $this->innerTemperature = $temperature;
        $this->yieldToday = $yieldToday;
        $this->yieldTotal = $yieldTotal;
        $this->yieldTotal2 = $yieldTotal2;
    }

    /**
     * @inheritDoc
     */
    public static function create(array $data): self
    {
        return new self(
            $data[Data::INVERTER_INNER_TEMPERATURE],
            $data[Data::INVERTER_YIELD_TODAY],
            $data[Data::INVERTER_YIELD_TOTAL],
            (float)$data[Data::INVERTER_YIELD_TOTAL_2]
        );
    }

    /**
     * @return int
     */
    public function getInnerTemperature(): int
    {
        return $this->innerTemperature;
    }

    /**
     * @return float
     */
    public function getYieldToday(): float
    {
        return $this->yieldToday;
    }

    /**
     * @return float
     */
    public function getYieldTotal(): float
    {
        return $this->yieldTotal;
    }

    /**
     * @return float
     */
    public function getYieldTotal2(): float
    {
        return $this->yieldTotal2;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
