<?php

declare(strict_types=1);

namespace loophp\nanobench\Analyzer;

use loophp\nanobench\Analyzer;

abstract class AbstractAnalyzer implements Analyzer
{
    protected int $times = 0;

    public function mark(): ?float
    {
        return null;
    }

    public function start(): Analyzer
    {
        return $this;
    }

    public function stop(): Analyzer
    {
        return $this;
    }

    public function withIterationResult(?float $start, mixed $result, ?float $stop): static
    {
        return clone $this;
    }
}
