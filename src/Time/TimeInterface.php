<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench\Time;

interface TimeInterface
{
    public function as(string $timeUnit): float;

    public function asDay(): float;

    public function asHour(): float;

    public function asMicrosecond(): float;

    public function asMillisecond(): float;

    public function asMinute(): float;

    public function asNanosecond(): float;

    public function asSecond(): float;

    public function asWeek(): float;
}
