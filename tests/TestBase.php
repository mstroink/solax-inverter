<?php
namespace MStroink\Solax\Tests;

use PHPUnit\Framework\TestCase;

class TestBase extends TestCase
{
    /**
     * @return mixed
     */
    protected function fixture(string $filename, bool $decode = true)
    {
        $data = file_get_contents(__DIR__ . '/Fixture/' . $filename);
        
        if ($data && $decode) {
            return json_decode($data, true);
        }

        return $data;
    }
}
