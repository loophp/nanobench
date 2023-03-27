<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench\Analyzer;

use DateInterval;
use DateTimeInterface;
use Lcobucci\Clock\SystemClock;
use loophp\nanobench\Analyzer;
use loophp\nanobench\DateIntervalHelper;
use Psr\Clock\ClockInterface;

final class AverageDuration extends AbstractAnalyzer
{
    private readonly ClockInterface $clock;

    private DateInterval $interval;

    public function __construct()
    {
        $this->interval = new DateInterval('PT0S');
        $this->clock = SystemClock::fromSystemTimezone();
    }

    public function getResult(): string
    {
        return sprintf(
            'One iteration lasted %6f seconds in average.',
            DateIntervalHelper::toSeconds($this->interval)
        );
    }

    public function mark(): DateTimeInterface
    {
        return $this->clock->now();
    }

    public function start(): Analyzer
    {
        return $this;
    }

    public function stop(): Analyzer
    {
        return $this;
    }

    public function withIterationResult(int $i, null|DateTimeInterface|float $start, mixed $result, null|DateTimeInterface|float $stop): static
    {
        $clone = clone $this;

        $clone->interval = DateIntervalHelper::divide(
            DateIntervalHelper::add(
                DateIntervalHelper::multiply($this->interval, $i),
                $stop->diff($start)
            ),
            $i + 1
        );

        return $clone;
    }
}
