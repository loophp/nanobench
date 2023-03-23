<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench\Analyzer;

use loophp\nanobench\Analyzer;

final class TotalMemory extends AbstractAnalyzer
{
    private float $start = 0;

    private float $stop = 0;

    public function getResult(): string
    {
        return sprintf(
            'The benchmark took %s of memory.',
            $this->convert($this->stop - $this->start)
        );
    }

    public function start(): Analyzer
    {
        $this->start = memory_get_usage();

        return $this;
    }

    public function stop(): Analyzer
    {
        $this->stop = memory_get_usage();

        return $this;
    }

    private function convert(float $size): string
    {
        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
        $i = (int) floor(log($size, 1024));

        return sprintf('%6f %s', $size / 1024 ** $i, $unit[$i]);
    }
}
