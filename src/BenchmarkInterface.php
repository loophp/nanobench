<?php

declare(strict_types=1);

namespace loophp\nanobench;

use Closure;
use SebastianBergmann\Timer\Duration;

interface BenchmarkInterface
{
    public static function fromCallable(callable $callable, ...$arguments): BenchmarkInterface;

    public static function fromClosure(Closure $closure, ...$arguments): BenchmarkInterface;

    public function getDuration(): Duration;

    public function getReturn();

    public function run(): BenchmarkInterface;
}
