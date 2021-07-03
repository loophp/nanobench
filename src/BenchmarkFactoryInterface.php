<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench;

use Closure;

interface BenchmarkFactoryInterface
{
    public function fromCallable(callable $callable, ...$arguments): BenchmarkInterface;

    public function fromClosure(Closure $closure, ...$arguments): BenchmarkInterface;
}
