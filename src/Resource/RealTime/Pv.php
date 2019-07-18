<?php

declare(strict_types=1);

namespace MStroink\Solax\Resource\RealTime;

use MStroink\Solax\Resource\DataInterface as Data;
use MStroink\Solax\Resource\ResourceInterface as Resource;

final class Pv implements Resource
{
    /**
     * @var float
     */
    protected $pv1Current;
    /**
     * @var float
     */
    protected $pv2Current;
    /**
     * @var float
     */
    protected $pv1Voltage;
    /**
     * @var float
     */
    protected $pv2Voltage;
    /**
     * @var int
     */
    protected $pv1Power;
    /**
     * @var int
     */
    protected $pv2Power;

    /**
     * @param float $pv1Current
     * @param float $pv2Current
     * @param float $pv1Voltage
     * @param float $pv2Voltage
     * @param int   $pv1Power
     * @param int   $pv2Power
     */
    public function __construct(
        float $pv1Current,
        float $pv2Current,
        float $pv1Voltage,
        float $pv2Voltage,
        int $pv1Power,
        int $pv2Power
    ) {
        $this->pv1Current = $pv1Current;
        $this->pv2Current = $pv2Current;
        $this->pv1Voltage = $pv1Voltage;
        $this->pv2Voltage = $pv2Voltage;
        $this->pv1Power = $pv1Power;
        $this->pv2Power = $pv2Power;
    }

    /**
     * @inheritDoc
     */
    public static function create(array $data): self
    {
        return new self(
            $data[Data::PV_PV1_CURRENT],
            $data[Data::PV_PV2_CURRENT],
            $data[Data::PV_PV1_VOLTAGE],
            $data[Data::PV_PV2_VOLTAGE],
            $data[Data::PV_PV1_POWER],
            $data[Data::PV_PV2_POWER]
        );
    }

    /**
     * @return float
     */
    public function getPv1Current(): float
    {
        return $this->pv1Current;
    }

    /**
     * @return float
     */
    public function getPv2Current(): float
    {
        return $this->pv2Current;
    }

    /**
     * @return float
     */
    public function getPv1Voltage(): float
    {
        return $this->pv1Voltage;
    }

    /**
     * @return float
     */
    public function getPv2Voltage(): float
    {
        return $this->pv2Voltage;
    }

    /**
     * @return int
     */
    public function getPv1Power(): int
    {
        return $this->pv1Power;
    }

    /**
     * @return int
     */
    public function getPv2Power(): int
    {
        return $this->pv2Power;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
