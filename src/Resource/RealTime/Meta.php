<?php

declare(strict_types=1);

namespace MStroink\Solax\Resource\RealTime;

use MStroink\Solax\Resource\ResourceInterface as Resource;

final class Meta implements Resource
{
    /**
     * @var string
     */
    protected $method;
    /**
     * @var string
     */
    protected $version;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $serialNumber;
    /**
     * @var int
     */
    protected $status;

    /**
     * @param string $method
     * @param string $version
     * @param string $type
     * @param string $serialNumber
     * @param int    $status
     */
    public function __construct(
        string $method,
        string $version,
        string $type,
        string $serialNumber,
        int $status
    ) {
        $this->method = $method;
        $this->version = $version;
        $this->type = $type;
        $this->serialNumber = $serialNumber;
        $this->status = $status;
    }

    /**
     * @inheritDoc
     */
    public static function create(array $data): self
    {
        return new self(
            $data['method'],
            $data['version'],
            $data['type'],
            $data['SN'],
            (int) $data['Status']
        );
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getSerialNumber(): string
    {
        return $this->serialNumber;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
