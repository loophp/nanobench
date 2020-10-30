<?php

declare(strict_types=1);

namespace loophp\nanobench\Time;

interface ClockInterface
{
    public function time(): TimeInterface;
}
