<?php

declare(strict_types=1);

namespace loophp\nanobench;

use Closure;
use Lcobucci\Clock\SystemClock;
use loophp\nanobench\Executor\Iteration;
use Psr\Clock\ClockInterface;

/**
 * @template T
 *
 * @implements BenchmarkInterface<T>
 */
final class Benchmark implements BenchmarkInterface
{
    public function __construct(
        private readonly Executor $executor,
        private readonly array $analyzers
    ) {
    }

    public function run(int|float $parameter, Closure $closure, mixed ...$arguments): array
    {
        return $this->executor->run($this->analyzers, $parameter, $closure, $arguments);
    }

    public static function withDefault(?Executor $executor = null, array $analyzers = [], ?ClockInterface $clock = null): self
    {
        $clock ??= SystemClock::fromUTC();

        return new self(
            null === $executor ? new Iteration() : $executor,
            [] !== $analyzers ? $analyzers : [
                new Analyzer\TotalDuration($clock),
                new Analyzer\TotalMemory(),
                new Analyzer\AverageDuration($clock),
                new Analyzer\AverageMemory(),
                new Analyzer\ClosureReturn(),
            ]
        );
    }
}
