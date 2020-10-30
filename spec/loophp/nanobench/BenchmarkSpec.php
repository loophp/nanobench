<?php

declare(strict_types=1);

namespace spec\loophp\nanobench;

use loophp\nanobench\Benchmark;
use loophp\nanobench\BenchmarkInterface;
use PhpSpec\ObjectBehavior;
use SebastianBergmann\Timer\Duration;

final class BenchmarkSpec extends ObjectBehavior
{
    public function it_benchmark_a_callable()
    {
        $this::fromCallable('strtoupper', 'hello')
            ->shouldReturnAnInstanceOf(BenchmarkInterface::class);
    }

    public function it_benchmark_a_closure()
    {
        $closure = static function (int $seconds): int {
            sleep($seconds);

            return $seconds;
        };

        $this::fromClosure($closure, 1)
            ->run()
            ->getDuration()
            ->shouldBeAnInstanceOf(Duration::class);

        $this::fromClosure($closure, 1)
            ->run()
            ->getDuration()
            ->asMilliseconds()
            ->shouldBeApproximately(1000, 250);

        $this::fromClosure($closure, 2)
            ->run()
            ->getReturn()
            ->shouldReturn(2);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Benchmark::class);
    }
}
