<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench\Time;

final class Clock implements ClockInterface
{
    public function time(): TimeInterface
    {
        [$usec, $sec] = explode(' ', microtime(), 2);

        return new Time((float) $usec + (float) $sec);
    }
}
