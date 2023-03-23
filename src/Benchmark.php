<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench;

use Closure;
use Generator;

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
        $analyzers = array_map(
            static fn (Analyzer $analyzer): Analyzer => $analyzer->start(),
            $this->analyzers
        );
        $analyzersIndex = array_keys($analyzers);

        foreach ($this->executeBench($analyzers, $times, $closure, $arguments) as $i => [$starts, ,$stops]) {
            $analyzers = array_map(
                static fn (Analyzer $analyzer, int $ai): Analyzer => $analyzer->withIterationResult($i, $starts[$ai], $stops[$ai]),
                $analyzers,
                $analyzersIndex
            );
        }

        return array_map(
            static fn (Analyzer $analyzer): Analyzer => $analyzer->withTotalIterations($times)->stop(),
            $analyzers
        );
    }

    private function executeBench(array $analyzers, int $times, Closure $closure, array $arguments): Generator
    {
        for ($i = 1; $i <= $times; ++$i) {
            yield $i => [
                array_map(
                    static fn (Analyzer $analyzer): mixed => $analyzer->mark(),
                    $analyzers
                ),
                ($closure)(...$arguments),
                array_map(
                    static fn (Analyzer $analyzer): mixed => $analyzer->mark(),
                    $analyzers
                ),
            ];
        }
    }
}
