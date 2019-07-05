<?php
declare (strict_types = 1);

namespace MStroink\Solax\Resource\RealTime;

use MStroink\Solax\Exception\CreatableException;
use MStroink\Solax\Resource\ResourceInterface as Resource;

final class RealTime implements Resource
{
    /**
     * @var Meta
     */
    public $Meta;
    /**
     * @var Pv
     */
    public $Pv;
    /**
     * @var Grid
     */
    public $Grid;
    /**
     * @var Inverter
     */
    public $Inverter;
    /**
     * @var Battery|null
     */
    public $Battery;

    /**
     * @param Meta    $meta
     * @param Pv      $pv
     * @param Grid    $grid
     * @param Inverter   $inverter
     * @param Battery|null $battery
     */
    public function __construct(
        Meta $meta,
        Pv $pv,
        Grid $grid,
        Inverter $inverter,
        ?Battery $battery = null
    ) {
        $this->Meta = $meta;
        $this->Pv = $pv;
        $this->Grid = $grid;
        $this->Inverter = $inverter;
        $this->Battery = $battery;
    }

    /**
     * @inheritDoc
     */
    public static function create(array $data): self
    {
        try {
            $battery = Battery::create($data['Data']);
        } catch (CreatableException $e) {
            $battery = null; //battery not installed
        }

        return new self(
            Meta::create($data),
            Pv::create($data['Data']),
            Grid::create($data['Data']),
            Inverter::create($data['Data']),
            $battery
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $data = [];
        foreach (get_object_vars($this) as $name => $value) {
            if ($value instanceof Resource) {
                $value = $value->toArray();
            }

            $data[$name] = $value;
        }

        return $data;
    }
}
