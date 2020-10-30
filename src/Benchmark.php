<?php

declare(strict_types=1);

namespace loophp\nanobench;

use Closure;
use SebastianBergmann\Timer\Duration;
use SebastianBergmann\Timer\Timer;

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
     * @var Duration
     */
    private $duration;

    /**
     * @var mixed
     */
    private $return;

    public static function fromCallable(callable $callable, ...$arguments): BenchmarkInterface
    {
        return self::fromClosure(Closure::fromCallable($callable), ...$arguments);
    }

    public static function fromClosure(Closure $closure, ...$arguments): BenchmarkInterface
    {
        $self = new self();

        $self->closure = $closure;
        $self->arguments = $arguments;

        return $self;
    }

    public function getDuration(): Duration
    {
        return $this->duration;
    }

    public function getReturn()
    {
        return $this->return;
    }

    public function run(): BenchmarkInterface
    {
        $stopwatch = new Timer();

        $stopwatch->start();
        $return = ($this->closure)(...$this->arguments);
        $this->duration = $stopwatch->stop();

        $this->return = $return;

        return $this;
    }
}
