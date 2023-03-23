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

    public function mark(): null|DateTimeInterface|float;

    public function start(): Analyzer;

    public function stop(): Analyzer;

    /**
     * @param mixed $start
     * @param mixed $stop
     */
    public function withIterationResult(int $i, $start, $stop): static;

    public function withTotalIterations(int $times): static;
}
