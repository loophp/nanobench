<?php

declare(strict_types=1);

namespace loophp\nanobench\Executor;

use Closure;
use loophp\nanobench\Analyzer;
use loophp\nanobench\Executor;

final class Time implements Executor
{
    public function run(array $analyzers, mixed $parameter, Closure $closure, array $arguments): array
    {
        return array_map(
            fn (Analyzer $analyzer): Analyzer => $this->executeBench($analyzer, $parameter, $closure, $arguments),
            $analyzers
        );
    }

    private function executeBench(Analyzer $analyzer, float $seconds, Closure $closure, array $arguments): Analyzer
    {
        $start = microtime(true);

        $analyzer = $analyzer->start();

        while (microtime(true) - $start <= $seconds) {
            $analyzer = $analyzer->withIterationResult(
                $analyzer->mark(),
                ($closure)(...$arguments),
                $analyzer->mark()
            );
        }

        return $analyzer->stop();
    }
}
