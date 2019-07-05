<?php
declare (strict_types = 1);

namespace MStroink\Solax\Resource;

/**
 * @see https://github.com/GitHobi/solax/wiki/74_SolaxDirect.pm-Readings
 * @see https://community.home-assistant.io/t/solax-solar-inverter-setup-guide/48008
 */
interface DataInterface
{
    const PV_PV1_CURRENT = 0;
    const PV_PV2_CURRENT = 1;
    const PV_PV1_VOLTAGE = 2;
    const PV_PV2_VOLTAGE = 3;
    const PV_PV1_POWER = 11;
    const PV_PV2_POWER = 12;

    const GRID_CURRENT = 4;
    const GRID_VOLTAGE = 5;
    const GRID_POWER = 6;
    const GRID_FEED_IN_POWER = 10;
    const GRID_FREQUENCY = 50;
    const GRID_EXPORTED = 41;
    const GRID_IMPORTED = 42;

    const BATTERY_VOLTAGE = 13;
    const BATTERY_POWER = 15;
    const BATTERY_TEMPERATURE = 16;
    const BATTERY_CURRENT = 14;
    const BATTERY_REMAINING_CAPACITY = 17;

    const INVERTER_INNER_TEMPERATURE = 7;
    const INVERTER_YIELD_TODAY = 8;
    const INVERTER_YIELD_TOTAL = 9;
    const INVERTER_YIELD_TOTAL_2 = 19;

    const HISTORY_SOLAR_TODAY = 0;
    const HISTORY_SOLAR_TOTAL = 4;
}
