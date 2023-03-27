<?php

declare(strict_types=1);

namespace loophp\nanobench;

use Closure;

interface Executor
{
    public function run(array $analyzers, mixed $parameter, Closure $closure, array $arguments): array;
}
