<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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
        ];
    }

    public function run(int $times, Closure $closure, mixed ...$arguments): array
    {
        return array_map(
            static fn (Analyzer $analyzer): Analyzer => $analyzer->stop()->withTotalIterations($times),
            array_map(
                static fn (Analyzer $analyzer): Analyzer => $this->executeBench($analyzer, $times, $closure, $arguments),
                array_map(
                    static fn (Analyzer $analyzer): Analyzer => $analyzer->start(),
                    $this->analyzers
                ),
            )
        );
    }

    private function executeBench(Analyzer $analyzer, int $times, Closure $closure, array $arguments): Analyzer
    {
        for ($i = 0; $i < $times; ++$i) {
            $analyzer = $analyzer->withIterationResult(
                $i,
                $analyzer->mark(),
                ($closure)(...$arguments),
                $analyzer->mark()
            );
        }

        return $analyzer;
    }
}
