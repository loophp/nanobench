<?php

declare(strict_types=1);

namespace spec\loophp\nanobench;

use Closure;
use loophp\nanobench\Benchmark;
use loophp\nanobench\BenchmarkInterface;
use loophp\nanobench\StopwatchFactory;
use loophp\nanobench\Time\Duration;
use loophp\nanobench\Time\StopwatchInterface;
use PhpSpec\ObjectBehavior;

final class BenchmarkSpec extends ObjectBehavior
{
    public function it_benchmark_a_callable()
    {
        $this
            ->beConstructedWith((new StopwatchFactory())->new(), Closure::fromCallable('strtoupper'), 'hello');

        $this
            ->shouldReturnAnInstanceOf(BenchmarkInterface::class);
    }

    public function it_benchmark_a_closure()
    {
        $closure = static function (int $seconds): int {
            sleep($seconds);

            return $seconds;
        };

        $this
            ->beConstructedWith((new StopwatchFactory())->new(), $closure, 1);

        $run = $this->run();

        $run
            ->getReturn()
            ->shouldReturn(1);

        $run
            ->getStopwatch()
            ->shouldBeAnInstanceOf(StopwatchInterface::class);

        $run
            ->getDuration()
            ->shouldBeAnInstanceOf(Duration::class);

        $run
            ->getDuration()
            ->asMillisecond()
            ->shouldBeApproximately(1000, 250);

        $run
            ->getDuration()
            ->asSecond()
            ->shouldBeApproximately(1, 0.1);
    }

    public function it_is_initializable()
    {
        $this
            ->beConstructedWith((new StopwatchFactory())->new(), Closure::fromCallable('strtoupper'), 'hello');

        $this->shouldHaveType(Benchmark::class);
    }
}
