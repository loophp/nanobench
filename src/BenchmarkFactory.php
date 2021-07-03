<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench;

use Closure;

final class BenchmarkFactory implements BenchmarkFactoryInterface
{
    public function fromCallable(callable $callable, ...$arguments): BenchmarkInterface
    {
        return $this->fromClosure(Closure::fromCallable($callable), ...$arguments);
    }

    public function fromClosure(Closure $closure, ...$arguments): BenchmarkInterface
    {
        return new Benchmark((new StopwatchFactory())->new(), $closure, ...$arguments);
    }
}
