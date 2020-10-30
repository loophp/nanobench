<?php

declare(strict_types=1);

namespace loophp\nanobench;

use Closure;
use loophp\nanobench\Time\StopwatchInterface;
use loophp\nanobench\Time\TimeInterface;

final class Benchmark implements BenchmarkInterface
{
    /**
     * @var array
     */
    private $arguments;

    /**
     * @var Closure
     */
    private $closure;

    /**
     * @var mixed
     */
    private $return;

    /**
     * @var StopwatchInterface
     */
    private $stopwatch;

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
        $this->stopwatch->start();
        $this->return = ($this->closure)(...$this->arguments);
        $this->stopwatch->stop();

        return $this;
    }
}
