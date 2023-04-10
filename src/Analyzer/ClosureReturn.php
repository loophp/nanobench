<?php

declare(strict_types=1);

namespace loophp\nanobench\Analyzer;

use function count;

final class ClosureReturn extends AbstractAnalyzer
{
    private bool $consistency = true;

    private array $returns = [];

    public function getResult(): string
    {
        return sprintf(
            'The Closure return value was %sconsistent during the benchmark.',
            $this->consistency ? '' : 'not '
        );
    }

    public function withIterationResult(?float $start, mixed $result, ?float $stop): static
    {
        $clone = clone $this;
        $clone->returns[] = $result;

        if (3 === count($clone->returns)) {
            $clone->returns = [$clone->returns[1], $clone->returns[2]];
            $clone->consistency = $clone->consistency && ($clone->returns[0] === $clone->returns[1]);
        }

        return $clone;
    }
}
