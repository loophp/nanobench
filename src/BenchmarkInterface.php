<?php

declare(strict_types=1);

namespace loophp\nanobench;

use loophp\nanobench\Time\StopwatchInterface;
use loophp\nanobench\Time\TimeInterface;

interface BenchmarkInterface
{
    public function getDuration(): TimeInterface;

    public function getReturn();

    public function getStopwatch(): StopwatchInterface;

    public function run(): BenchmarkInterface;
}
