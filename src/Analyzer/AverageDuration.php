<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench\Analyzer;

use Lcobucci\Clock\SystemClock;
use loophp\nanobench\Analyzer;
use Psr\Clock\ClockInterface;

final class AverageDuration extends AbstractAnalyzer
{
    private readonly ClockInterface $clock;

    private float $interval;

    public function __construct()
    {
        $this->interval = 0.0;
        $this->clock = SystemClock::fromSystemTimezone();
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

    public function withIterationResult(int $i, ?float $start, mixed $result, ?float $stop): static
    {
        $clone = clone $this;

        $clone->interval = (($this->interval * $i) + ($stop - $start)) / ($i + 1);

        return $clone;
    }
}
