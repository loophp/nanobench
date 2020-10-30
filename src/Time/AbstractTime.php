<?php

declare(strict_types=1);

namespace loophp\nanobench\Time;

use Exception;

abstract class AbstractTime implements TimeInterface
{
    /**
     * @var float
     */
    protected $time;

    /**
     * @var string
     */
    protected $unit;

    protected function convertTo(string $unit): float
    {
        // Convert to seconds.
        switch ($this->unit) {
            case TimeUnit::NANOSECOND:
                $time = $this->time / 10 ** 9;

                break;
            case TimeUnit::MICROSECOND:
                $time = $this->time / 10 ** 6;

                break;
            case TimeUnit::MILLISECOND:
                $time = $this->time / 10 ** 3;

                break;
            case TimeUnit::SECOND:
                $time = $this->time;

                break;
            case TimeUnit::MINUTE:
                $time = $this->time * 60;

                break;
            case TimeUnit::HOUR:
                $time = $this->time * 60 * 60;

                break;
            case TimeUnit::DAY:
                $time = $this->time * 60 * 60 * 24;

                break;
            case TimeUnit::WEEK:
                $time = $this->time * 60 * 60 * 24 * 7;

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
