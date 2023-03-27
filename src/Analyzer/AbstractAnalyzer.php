<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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

    public function withIterationResult(int $i, ?float $start, mixed $result, ?float $stop): static
    {
        return clone $this;
    }

    public function withTotalIterations(int $times): static
    {
        $clone = clone $this;
        $clone->times = $times;

        return $clone;
    }
}
