<?php

declare(strict_types=1);

namespace loophp\nanobench;

use Closure;

interface BenchmarkFactoryInterface
{
    public function fromCallable(callable $callable, ...$arguments): BenchmarkInterface;

    public function fromClosure(Closure $closure, ...$arguments): BenchmarkInterface;
}
