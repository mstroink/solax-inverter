<?php

declare(strict_types=1);

namespace MStroink\Solax\Resource\RealTime;

use MStroink\Solax\Exception\CreatableException;
use MStroink\Solax\Resource\ResourceInterface as Resource;
use MStroink\Solax\Resource\DataInterface as Data;

final class Battery implements Resource
{
    /**
     * @var float
     */
    protected $voltage;
    /**
     * @var float
     */
    protected $power;
    /**
     * @var float
     */
    protected $temperature;
    /**
     * @var float
     */
    protected $charge;
    /**
     * @var float
     */
    protected $remainCapacity;

    /**
     * @param float $voltage
     * @param float $power
     * @param float $temperature
     * @param float $charge
     * @param float $remainCapacity
     */
    public function __construct(
        float $voltage,
        float $power,
        float $temperature,
        float $charge,
        float $remainCapacity
    ) {
        $this->voltage = $voltage;
        $this->power = $power;
        $this->temperature = $temperature;
        $this->charge = $charge;
        $this->remainCapacity = $remainCapacity;
    }

    public static function create(array $data): self
    {
        if ($data[Data::BATTERY_VOLTAGE] == "" || $data[Data::BATTERY_CURRENT] == "") {
            throw new CreatableException("Invalid battery data");
        }

        return new self(
            $data[Data::BATTERY_VOLTAGE],
            $data[Data::BATTERY_POWER],
            $data[Data::BATTERY_TEMPERATURE],
            $data[Data::BATTERY_CURRENT],
            $data[Data::BATTERY_REMAINING_CAPACITY]
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
