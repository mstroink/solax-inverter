<?php
namespace MStroink\Solax\Http;

use Http\Client\HttpClient;

interface ClientConfiguratorInterface
{
    public function createConfiguredClient(): HttpClient;
}
