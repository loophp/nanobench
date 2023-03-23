<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench\Analyzer;

use loophp\nanobench\Analyzer;

/**
 * @template T
 */
final class AverageMemory extends AbstractAnalyzer
{
    private float $memory = 0.0;

    public function getResult(): string
    {
        return $this->convert($this->memory);
    }

    public function mark(): float
    {
        return memory_get_usage();
    }

    public function start(): Analyzer
    {
        return $this;
    }

    public function stop(): Analyzer
    {
        return $this;
    }

    public function withIterationResult(int $i, $start, $stop): static
    {
        $clone = clone $this;
        $clone->memory = ($this->memory * ($i - 1) + ($stop - $start)) / $i;

        return $clone;
    }

    private function convert(float $size): string
    {
        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
        $i = (int) floor(log($size, 1024));

        return sprintf('%6f %s', $size / 1024 ** $i, $unit[$i]);
    }
}
