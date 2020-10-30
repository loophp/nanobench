<?php

declare(strict_types=1);

namespace loophp\nanobench\Time;

final class Clock implements ClockInterface
{
    public function time(): TimeInterface
    {
        [$usec, $sec] = explode(' ', microtime(), 2);

        return new Time((float) $usec + (float) $sec, TimeUnit::SECOND);
    }
}
