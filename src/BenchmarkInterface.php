<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench;

use Closure;

/**
 * @template T
 */
interface BenchmarkInterface
{
    /**
     * @param Closure(): T $closure
     */
    public function run(int $times, Closure $closure, mixed ...$arguments): array;
}
