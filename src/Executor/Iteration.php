<?php

declare(strict_types=1);

namespace loophp\nanobench\Executor;

use Closure;
use loophp\nanobench\Analyzer;
use loophp\nanobench\Executor;

final class Iteration implements Executor
{
    public function run(array $analyzers, mixed $parameter, Closure $closure, array $arguments): array
    {
        return array_map(
            fn (Analyzer $analyzer): Analyzer => $this->executeBench($analyzer, $parameter, $closure, $arguments),
            $analyzers
        );
    }

    private function executeBench(Analyzer $analyzer, int $times, Closure $closure, array $arguments): Analyzer
    {
        $analyzer = $analyzer->start();

        for ($i = 0; $i < $times; ++$i) {
            $analyzer = $analyzer->withIterationResult(
                $analyzer->mark(),
                ($closure)(...$arguments),
                $analyzer->mark()
            );
        }

        return $analyzer->stop();
    }
}
