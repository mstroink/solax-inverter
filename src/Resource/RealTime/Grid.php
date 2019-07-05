<?php
declare (strict_types = 1);

namespace MStroink\Solax\Resource\RealTime;

use MStroink\Solax\Resource\ResourceInterface as Resource;
use MStroink\Solax\Resource\DataInterface as Data;

final class Grid implements Resource
{
    /**
     * @var float
     */
    protected $current;
    /**
     * @var float
     */
    protected $voltage;
    /**
     * @var int
     */
    protected $power;
    /**
     * @var int
     */
    protected $feedInPower;
    /**
     * @var float
     */
    protected $frequency;
    /**
     * @var float
     */
    protected $exported;
    /**
     * @var float
     */
    protected $imported;

    /**
     * @param float $current
     * @param float $voltage
     * @param int   $power
     * @param int   $feedInPower
     * @param float $frequency
     * @param float $exported
     * @param float $imported
     */
    public function __construct(
        float $current,
        float $voltage,
        int $power,
        int $feedInPower,
        float $frequency,
        float $exported,
        float $imported
    ) {
        $this->current = $current;
        $this->voltage = $voltage;
        $this->power = $power;
        $this->feedInPower = $feedInPower;
        $this->frequency = $frequency;
        $this->exported = $exported;
        $this->imported = $imported;
    }

    public static function create(array $data): self
    {
        return new self(
            $data[Data::GRID_CURRENT],
            $data[Data::GRID_VOLTAGE],
            $data[Data::GRID_POWER],
            $data[Data::GRID_FEED_IN_POWER],
            $data[Data::GRID_FREQUENCY],
            (float) $data[Data::GRID_EXPORTED],
            (float) $data[Data::GRID_IMPORTED]
        );
    }

    /**
     * @return float
     */
    public function getCurrent(): float
    {
        return $this->current;
    }

    /**
     * @return float
     */
    public function getVoltage(): float
    {
        return $this->voltage;
    }

    /**
     * @return int
     */
    public function getPower(): int
    {
        return $this->power;
    }

    /**
     * @return int
     */
    public function getFeedInPower(): int
    {
        return $this->feedInPower;
    }

    /**
     * @return float
     */
    public function getFrequency(): float
    {
        return $this->frequency;
    }

    /**
     * @return float
     */
    public function getExported(): float
    {
        return $this->exported;
    }

    /**
     * @return float
     */
    public function getImported(): float
    {
        return $this->imported;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
