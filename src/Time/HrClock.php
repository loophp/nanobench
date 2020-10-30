<?php

declare(strict_types=1);

namespace loophp\nanobench\Time;

final class HrClock implements ClockInterface
{
    public function time(): TimeInterface
    {
        $hrtime = hrtime();

        return new Time($hrtime[0] + $hrtime[1] / 10 ** 9);
    }
}
