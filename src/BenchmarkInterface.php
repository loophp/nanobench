<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench;

use loophp\nanobench\Time\StopwatchInterface;
use loophp\nanobench\Time\TimeInterface;

interface BenchmarkInterface
{
    public function getDuration(): TimeInterface;

    /**
     * @return mixed
     */
    public function getReturn();

    public function getStopwatch(): StopwatchInterface;

    public function run(): BenchmarkInterface;
}
