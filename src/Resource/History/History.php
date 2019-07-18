<?php

declare(strict_types=1);

namespace MStroink\Solax\Resource\History;

use MStroink\Solax\Resource\DataInterface as Data;
use MStroink\Solax\Resource\ResourceInterface as Resource;

class History implements Resource
{
    /**
     * @var float
     */
    protected $solarToday;

    /**
     * @var float
     */
    protected $solarTotal;

    public function __construct(float $solarToday, float $solarTotal)
    {
        $this->solarToday = $solarToday;
        $this->solarTotal = $solarTotal;
    }

    public static function create(array $data): self
    {
        return new self(
            (float) $data[Data::HISTORY_SOLAR_TODAY],
            (float) $data[Data::HISTORY_SOLAR_TOTAL]
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * @return float
     */
    public function getSolarToday(): float
    {
        return $this->solarToday;
    }

    /**
     * @return float
     */
    public function getSolarTotal(): float
    {
        return $this->solarTotal;
    }
}
