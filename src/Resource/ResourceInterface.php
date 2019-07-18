<?php

declare(strict_types=1);

namespace MStroink\Solax\Resource;

interface ResourceInterface
{
    public static function create(array $data);
    public function toArray(): array;
}
