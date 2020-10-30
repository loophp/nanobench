<?php

declare(strict_types=1);

namespace spec\loophp\nanobench\Time;

use loophp\nanobench\Time\HrClock;
use loophp\nanobench\Time\Time;
use PhpSpec\ObjectBehavior;

class HrClockSpec extends ObjectBehavior
{
    public function it_can_get_time()
    {
        $this
            ->time()
            ->shouldBeAnInstanceOf(Time::class);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(HrClock::class);
    }
}
