<?php

declare(strict_types=1);

namespace loophp\nanobench;

use Closure;
use loophp\nanobench\Executor\IterationBased;

/**
 * @template T
 *
 * @implements BenchmarkInterface<T>
 */
final class Benchmark implements BenchmarkInterface
{
    public function __construct(private readonly Executor $executor, private readonly array $analyzers)
    {
    }

    public function run(int $times, Closure $closure, mixed ...$arguments): array
    {
        return $this->executor->run($this->analyzers, $times, $closure, $arguments);
    }

    public static function withDefault(string $executor = '', array $analyzers = []): self
    {
        return new self(
            '' !== $executor ? new $executor() : new IterationBased(),
            [] !== $analyzers ? $analyzers : [
                new Analyzer\TotalDuration(),
                new Analyzer\TotalMemory(),
                new Analyzer\AverageDuration(),
                new Analyzer\AverageMemory(),
                new Analyzer\ClosureReturn(),
            ]
        );
    }
}
