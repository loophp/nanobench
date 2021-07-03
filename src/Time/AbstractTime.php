<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench\Time;

use Exception;

abstract class AbstractTime implements TimeInterface
{
    protected string $unit;

    protected function convertTo(float $time, string $unit): float
    {
        // Convert to seconds.
        switch ($this->unit) {
            case TimeUnit::NANOSECOND:
                $time = $time / 10 ** 9;

                break;

            case TimeUnit::MICROSECOND:
                $time = $time / 10 ** 6;

                break;

            case TimeUnit::MILLISECOND:
                $time = $time / 10 ** 3;

                break;

            case TimeUnit::SECOND:
                $time = $time;

                break;

            case TimeUnit::MINUTE:
                $time = $time * 60;

                break;

            case TimeUnit::HOUR:
                $time = $time * 60 * 60;

                break;

            case TimeUnit::DAY:
                $time = $time * 60 * 60 * 24;

                break;

            case TimeUnit::WEEK:
                $time = $time * 60 * 60 * 24 * 7;

                break;
        }

        switch ($unit) {
            case TimeUnit::NANOSECOND:
                return $time * 10 ** 9;

            case TimeUnit::MICROSECOND:
                return $time * 10 ** 6;

            case TimeUnit::MILLISECOND:
                return $time * 10 ** 3;

            case TimeUnit::SECOND:
                return $time;

            case TimeUnit::MINUTE:
                return $time / 60;

            case TimeUnit::HOUR:
                return $time / (60 * 60);

            case TimeUnit::DAY:
                return $time / (60 * 60 * 24);

            case TimeUnit::WEEK:
                return $time / (60 * 60 * 24 * 7);
        }

        throw new Exception('Unable to convert.');
    }
}
