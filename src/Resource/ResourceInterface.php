<?php
namespace MStroink\Solax\Resource;

interface ResourceInterface
{
    public static function create(array $data);
    public function toArray(): array;
}
