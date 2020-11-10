<?php

declare(strict_types=1);

namespace loophp\nanobench\Time;

final class Duration extends AbstractTime
{
    /**
     * @var TimeInterface
     */
    private $from;

    /**
     * @var TimeInterface
     */
    private $to;

    public function __construct(TimeInterface $from, TimeInterface $to, string $unit = TimeUnit::SECOND)
    {
        $this->from = $from;
        $this->to = $to;
        $this->unit = $unit;
    }

    public function as(string $timeUnit): float
    {
        return $this->diff()->as($timeUnit);
    }

    public function asDay(): float
    {
        return $this->diff()->asDay();
    }

    public function asHour(): float
    {
        return $this->diff()->asHour();
    }

    public function asMicrosecond(): float
    {
        return $this->diff()->asMicrosecond();
    }

    public function asMillisecond(): float
    {
        return $this->diff()->asMillisecond();
    }

    public function asMinute(): float
    {
        return $this->diff()->asMinute();
    }

    public function asNanosecond(): float
    {
        return $this->diff()->asNanosecond();
    }

    public function asSecond(): float
    {
        return $this->diff()->asSecond();
    }

    public function asWeek(): float
    {
        return $this->diff()->asWeek();
    }

    private function diff(): TimeInterface
    {
        return new Time(abs($this->from->asSecond() - $this->to->asSecond()));
    }
}
