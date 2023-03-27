<?php

declare(strict_types=1);

namespace loophp\nanobench\Analyzer;

use Exception;

final class ClosureReturn extends AbstractAnalyzer
{
    private mixed $return;

    public function getResult(): string
    {
        return sprintf(
            'The Closure return (%s) was consistent across the %s iterations.',
            $this->return,
            $this->times
        );
    }

    public function withIterationResult(int $i, ?float $start, mixed $result, ?float $stop): static
    {
        if (!isset($this->return)) {
            $clone = clone $this;
            $clone->return = $result;

            return $clone;
        }

        if ($this->return !== $result) {
            throw new Exception('Result different');
        }

        return $this;
    }
}
