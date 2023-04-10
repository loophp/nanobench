<?php

declare(strict_types=1);

namespace loophp\nanobench\Analyzer;

use DateTimeInterface;
use DateTimeZone;
use Lcobucci\Clock\SystemClock;
use loophp\nanobench\Analyzer;
use loophp\nanobench\DateIntervalHelper;
use Psr\Clock\ClockInterface;

final class TotalDuration extends AbstractAnalyzer
{
    private DateTimeInterface $start;

    private DateTimeInterface $stop;

    public function __construct(
        private readonly ClockInterface $clock,
    ) {
        $this->start = $this->stop = $clock->now();
    }

    public function getResult(): string
    {
        return sprintf(
            'The benchmark started at %s, ended at %s. The %d iterations lasted %6f seconds.',
            $this->start->format('h:i:s.u'),
            $this->stop->format('h:i:s.u'),
            $this->times,
            DateIntervalHelper::toSeconds($this->stop->diff($this->start))
        );
    }

    public function start(): Analyzer
    {
        $this->start = $this->clock->now();

        return $this;
    }

    public function stop(): Analyzer
    {
        $this->stop = $this->clock->now();

        return $this;
    }

    public function withIterationResult(?float $start, mixed $result, ?float $stop): static
    {
        $this->times++;

        return $this;
    }
}
