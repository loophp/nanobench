<?php

declare(strict_types=1);

namespace spec\loophp\nanobench\Time;

use loophp\nanobench\Time\Duration;
use loophp\nanobench\Time\TimeInterface;
use loophp\nanobench\Time\TimeUnit;
use PhpSpec\ObjectBehavior;

class DurationSpec extends ObjectBehavior
{
    public function it_can_get_time_in_different_unit()
    {
        $this
            ->asNanosecond()
            ->shouldReturn(100000000000.0);

        $this
            ->asMicrosecond()
            ->shouldReturn(100000000.0);

        $this
            ->asMillisecond()
            ->shouldReturn(100000.0);

        $this
            ->asSecond()
            ->shouldReturn(100.0);

        $this
            ->asMinute()
            ->shouldBeApproximately(1.66, 0.01);

        $this
            ->asHour()
            ->shouldBeApproximately(0.027, 0.001);

        $this
            ->asDay()
            ->shouldBeApproximately(0.001157, 0.000001);

        $this
            ->asWeek()
            ->shouldBeApproximately(0.0001653, 0.0000001);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Duration::class);
    }

    public function let(TimeInterface $time1, TimeInterface $time2)
    {
        $time1
            ->beConstructedWith([200, TimeUnit::SECOND]);

        $time2
            ->beConstructedWith([100, TimeUnit::SECOND]);

        $time1
            ->asSecond()
            ->willReturn(200);

        $time2
            ->asSecond()
            ->willReturn(100);

        $this->beConstructedWith($time1, $time2);
    }
}
