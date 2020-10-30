<?php

declare(strict_types=1);

namespace loophp\nanobench;

use loophp\nanobench\Time\Clock;
use loophp\nanobench\Time\HrClock;
use loophp\nanobench\Time\Stopwatch;
use loophp\nanobench\Time\StopwatchInterface;

use const PHP_VERSION_ID;

final class StopwatchFactory implements StopwatchFactoryInterface
{
    public function new(): StopwatchInterface
    {
        $clock = PHP_VERSION_ID >= 70300 ? new HrClock() : new Clock();

        return new Stopwatch($clock);
    }
}
