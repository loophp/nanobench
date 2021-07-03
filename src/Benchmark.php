<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\nanobench;

use Closure;
use Generator;
use loophp\nanobench\Time\StopwatchInterface;
use loophp\nanobench\Time\TimeInterface;

/**
 * @psalm-template T
 */
final class Benchmark implements BenchmarkInterface
{
    /**
     * @psalm-var list<T>
     */
    private array $arguments;

    /**
     * @psalm-var Closure(T...): T
     */
    private Closure $closure;

    /**
     * @var mixed|null
     * @psalm-var T|null
     */
    private $return;

    private StopwatchInterface $stopwatch;

    /**
     * @psalm-param Closure(T...): T $closure
     * @psalm-param T ...$arguments
     */
    public function __construct(StopwatchInterface $stopwatch, Closure $closure, ...$arguments)
    {
        $this->stopwatch = $stopwatch->reset();
        $this->closure = $closure;
        $this->arguments = $arguments;
    }

    public function getDuration(): TimeInterface
    {
        return $this->stopwatch->getDiffFromTo('start', 'stop');
    }

    /**
     * @return mixed|null
     * @psalm-return T|null
     */
    public function getReturn()
    {
        return $this->return;
    }

    public function getStopwatch(): StopwatchInterface
    {
        return $this->stopwatch;
    }

    public function run(): BenchmarkInterface
    {
        [,$return,] = iterator_to_array($this->benchRunner());

        $this->return = $return;

        return $this;
    }

    private function benchRunner(): Generator
    {
        yield $this->stopwatch->start();

        yield ($this->closure)(...$this->arguments);

        yield $this->stopwatch->stop();
    }
}
