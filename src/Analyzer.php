<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench;

interface Analyzer
{
    public function getResult(): mixed;

    public function mark(): ?float;

    public function start(): Analyzer;

    public function stop(): Analyzer;

    public function withIterationResult(int $i, ?float $start, mixed $result, ?float $stop): static;

    public function withTotalIterations(int $times): static;
}
