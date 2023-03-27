<?php

declare(strict_types=1);

namespace loophp\nanobench;

use Closure;

/**
 * @template T
 */
interface BenchmarkInterface
{
    /**
     * @param Closure(mixed...): T $closure
     *
     * @return array<int, Analyzer>
     */
    public function run(int $times, Closure $closure, mixed ...$arguments): array;
}
