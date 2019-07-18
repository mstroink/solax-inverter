<p align="center">
    <a href="https://travis-ci.org/mstroink/solax-inverter" target="_blank">
        <img alt="Build Status" src="https://travis-ci.org/mstroink/solax-inverter.svg?branch=master">
    </a>
    <a href="https://codecov.io/gh/mstroink/solax-inverter" target="_blank">
        <img alt="Coverage Status" src="https://codecov.io/gh/mstroink/solax-inverter/branch/master/graph/badge.svg">
    </a>
    <a href="https://packagist.org/packages/mstroink/steca-grid" target="_blank">
        <img alt="Stable" src="https://poser.pugx.org/mstroink/solax-inverter/v/stable.svg">
    </a>
    <a href="https://php.net" target="_blank">
        <img alt="php Version" src="https://img.shields.io/badge/php-%3E=%207.1-8892BF.svg">
    </a>
</p>

# Solax Inverter

Simple PHP Client for reading realtime data from the Solax inverter

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Support](#support)

## Installation

Via Composer:
If you just want to get started quickly you should run the following:

```sh
$ composer require mstroink/solax-inverter php-http/guzzle6-adapter php-http/message
```

Why `php-http/guzzle6-adapter php-http/message`? We are decoupled from any HTTP messaging client with help by 
[HTTPlug](http://httplug.io/). Read about clients in the [HTTPlug docs](http://docs.php-http.org/en/latest/httplug/users.html).


## Usage
Ensure inverter is connected to your network. [Guide (pdf)](https://www.solaxpower.com/wp-content/uploads/2017/01/WiFi-Set-UP-Guide%C2%A3%C2%AESolaX-Portal.pdf)
Confirm datastream from inverter by checking you can access the following URL and get a response. http://INVERTERIP/api/historyData.htm

##### Default adapter
Initializing Inverter client with guzzle6-adapter and some default settings (timeout etc.)

```php
require 'vendor/autoload.php';

use MStroink\Solax\Inverter;

$inverter = Inverter:create('192.168.178.10');
```

##### Other adapter
Here is a list of all officially supported clients and adapters by HTTPlug: http://docs.php-http.org/en/latest/clients.html

Note the timeout: At night there is not enough sunlight to power the inverter.

```php
require 'vendor/autoload.php';

use MStroink\Solax\Http\HttpClientConfigurator;
use MStroink\Solax\Inverter;
use Cake\Http\Client as CakeClient;

$clientConfigurator = (new HttpClientConfigurator())
    ->setHost('192.168.178.10');
    ->setClient(new CakeClient(['timeout' => 10]));

$inverter = new Inverter($clientConfigurator)
```

##### Response

```php
try {
    $response = $inverter->getRealTimeData();

    echo $response->Inverter->getYieldToday() . "\n";
    echo $response->Inverter->getYieldTotal() . "\n";
    echo $response->Inverter->getInnerTemperature() . "\n";

    $response->Grid->getCurrent();
    $response->Grid->getExported();
    $response->Grid->getFeedInPower();
    $response->Grid->getFrequency();
    $response->Grid->getImported();
    $response->Grid->getPower();
    $response->Grid->getVoltage();

    $response->Meta->getMethod();
    $response->Meta->getSerialNumber();
    $response->Meta->getStatus();
    $response->Meta->getType();
    $response->Meta->getVersion();

    $response->Pv->getPv1Current();
    $response->Pv->getPv1Power();
    $response->Pv->getPv1Voltage();
    $response->Pv->getPv2Current();
    $response->Pv->getPv2Power();
    $response->Pv->getPv2Voltage();

    $response->toArray();
} catch (HttpServerException $e) {
    //inverter is offline?
}
```

## Tests
```
vendor/bin/phpunit
```

## Support

Please [open an issue](https://github.com/mstroink/solax-inverter/issues/new) for support.