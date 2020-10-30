<?php

declare(strict_types=1);

namespace loophp\nanobench;

use loophp\nanobench\Time\StopwatchInterface;

interface StopwatchFactoryInterface
{
    public function new(): StopwatchInterface;
}
