<?php

declare(strict_types=1);

namespace loophp\nanobench;

use Closure;

/**
 * @template T
 *
 * @implements BenchmarkInterface<T>
 */
final class Benchmark implements BenchmarkInterface
{
    /**
     * @var array<int, Analyzer>
     */
    private array $analyzers;

    public function __construct()
    {
        $this->analyzers = [
            new Analyzer\TotalDuration(),
            new Analyzer\TotalMemory(),
            new Analyzer\AverageDuration(),
            new Analyzer\AverageMemory(),
            new Analyzer\ClosureReturn(),
        ];
    }

    public function run(int $times, Closure $closure, mixed ...$arguments): array
    {
        return array_map(
            fn (Analyzer $analyzer): Analyzer => $this->executeBench($analyzer, $times, $closure, $arguments),
            $this->analyzers
        );
    }

    public function runDuring(float $seconds, Closure $closure, mixed ...$arguments): array
    {
        return array_map(
            fn (Analyzer $analyzer): Analyzer => $this->executeBenchFor($analyzer, $seconds, $closure, $arguments),
            $this->analyzers
        );
    }

    private function executeBench(Analyzer $analyzer, int $times, Closure $closure, array $arguments): Analyzer
    {
        $analyzer = $analyzer->start();

        for ($i = 0; $i < $times; ++$i) {
            $analyzer = $analyzer->withIterationResult(
                $i,
                $analyzer->mark(),
                ($closure)(...$arguments),
                $analyzer->mark()
            );
        }

        return $analyzer->stop()->withTotalIterations($times);
    }

    private function executeBenchFor(Analyzer $analyzer, float $seconds, Closure $closure, array $arguments): Analyzer
    {
        $times = 0;
        $start = microtime(true);

        $analyzer = $analyzer->start();

        while (microtime(true) - $start <= $seconds) {
            $analyzer = $analyzer->withIterationResult(
                $times++,
                $analyzer->mark(),
                ($closure)(...$arguments),
                $analyzer->mark()
            );
        }

        return $analyzer->stop()->withTotalIterations($times);
    }
}
