<?php

declare(strict_types=1);

namespace loophp\nanobench\Time;

final class Time extends AbstractTime
{
    /**
     * @var float
     */
    protected $time;

    public function __construct(float $time, string $unit = TimeUnit::SECOND)
    {
        $this->time = $time;
        $this->unit = $unit;
    }

    public function as(string $timeUnit): float
    {
        return $this->convertTo($this->time, $timeUnit);
    }

    public function asDay(): float
    {
        return $this->convertTo($this->time, TimeUnit::DAY);
    }

    public function asHour(): float
    {
        return $this->convertTo($this->time, TimeUnit::HOUR);
    }

    public function asMicrosecond(): float
    {
        return $this->convertTo($this->time, TimeUnit::MICROSECOND);
    }

    public function asMillisecond(): float
    {
        return $this->convertTo($this->time, TimeUnit::MILLISECOND);
    }

    public function asMinute(): float
    {
        return $this->convertTo($this->time, TimeUnit::MINUTE);
    }

    public function asNanosecond(): float
    {
        return $this->convertTo($this->time, TimeUnit::NANOSECOND);
    }

    public function asSecond(): float
    {
        return $this->convertTo($this->time, TimeUnit::SECOND);
    }

    public function asWeek(): float
    {
        return $this->convertTo($this->time, TimeUnit::WEEK);
    }
}
