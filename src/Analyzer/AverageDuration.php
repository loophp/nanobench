<?php

declare(strict_types=1);

namespace loophp\nanobench\Analyzer;

use loophp\nanobench\Analyzer;
use Psr\Clock\ClockInterface;

final class AverageDuration extends AbstractAnalyzer
{
    private float $interval = 0.0;

    private int $i = 0;

    public function __construct(
        private readonly ClockInterface $clock
    ) {
    }

    public function getResult(): string
    {
        return sprintf(
            'One iteration lasted %6f seconds in average.',
            $this->interval
        );
    }

    public function mark(): float
    {
        return (float) $this->clock->now()->format('U.u');
    }

    public function start(): Analyzer
    {
        return $this;
    }

    public function stop(): Analyzer
    {
        return $this;
    }

    public function withIterationResult(?float $start, mixed $result, ?float $stop): static
    {
        $clone = clone $this;

        $clone->interval = (($this->interval * $clone->i) + ($stop - $start)) / ($clone->i + 1);
        $clone->i++;

        return $clone;
    }
}
