<?php

declare(strict_types=1);

namespace loophp\nanobench\Executor;

use Closure;
use loophp\nanobench\Executor;

final class Grouped implements Executor
{
    public function __construct(private Executor $executor)
    {
    }

    public function run(array $analyzers, mixed $parameter, Closure $closure, array $arguments): array
    {
        for ($j = 0; $j < 10; $j++) {
            $analyzers = $this->executor->run($analyzers, $parameter, $closure, $arguments);
        }

        return $analyzers;
    }
}
