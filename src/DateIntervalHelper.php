<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench;

use DateInterval;
use Exception;

/**
 * @internal
 */
final class DateIntervalHelper
{
    public static function add(DateInterval ...$interval): DateInterval
    {
        $dateInterval = DateInterval::createFromDateString(
            self::hrTimeToDateString(
                array_reduce(
                    $interval,
                    static fn (float $carry, DateInterval $current): float => $carry + self::dateIntervalToFloat($current),
                    0.0
                )
            )
        );

        if (false === $dateInterval) {
            throw new Exception('Unable to add date intervals...');
        }

        return $dateInterval;
    }

    public static function divide(DateInterval $interval, float|int $divisor): DateInterval
    {
        $dateInterval = DateInterval::createFromDateString(
            self::hrTimeToDateString(self::dateIntervalToFloat($interval) / $divisor)
        );

        if (false === $dateInterval) {
            throw new Exception('Unable to divide the date interval...');
        }

        return $dateInterval;
    }

    public static function multiply(DateInterval $interval, float|int $multiply): DateInterval
    {
        $dateInterval = DateInterval::createFromDateString(
            self::hrTimeToDateString(self::dateIntervalToFloat($interval) * $multiply)
        );

        if (false === $dateInterval) {
            throw new Exception('Unable to multiply the date interval...');
        }

        return $dateInterval;
    }

    public static function toSeconds(DateInterval $interval): float
    {
        return self::dateIntervalToFloat($interval);
    }

    private static function dateIntervalToFloat(DateInterval $interval): float
    {
        return (float) sprintf(
            '%s.%s',
            (int) $interval->format('%d') * 86400 +
            (int) $interval->format('%h') * 3600 +
            (int) $interval->format('%i') * 60 +
            (int) $interval->format('%s'),
            $interval->format('%F')
        );
    }

    private static function hrTimeToDateString(float $hrTime): string
    {
        $hrTime = (float) number_format($hrTime, 6);

        $microseconds = ($hrTime - (int) $hrTime) * (10 ** 6);
        $hrTime = (int) $hrTime;

        $days = intdiv($hrTime, 86400);
        $hours = intdiv($hrTime - ($days * 86400), 3600);
        $minutes = intdiv($hrTime - ($hours * 3600), 60);
        $seconds = ($hrTime - $days - $hours - $minutes * 60);

        return sprintf(
            '%d days %d hours %d minutes %d seconds %d microseconds',
            $days,
            $hours,
            $minutes,
            $seconds,
            $microseconds
        );
    }
}
