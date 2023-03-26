<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench;

use DateTimeInterface;

interface Analyzer
{
    public function getResult(): mixed;

    public function mark(): null|DateTimeInterface|float;

    public function start(): Analyzer;

    public function stop(): Analyzer;

    public function withIterationResult(int $i, null|DateTimeInterface|float $start, null|DateTimeInterface|float $stop): static;

    public function withTotalIterations(int $times): static;
}
