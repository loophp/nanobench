<?php

declare(strict_types=1);

namespace spec\loophp\nanobench\Time;

use Exception;
use InvalidArgumentException;
use LogicException;
use loophp\nanobench\Time\HrClock;
use loophp\nanobench\Time\Stopwatch;
use loophp\nanobench\Time\TimeInterface;
use PhpSpec\ObjectBehavior;

class StopwatchSpec extends ObjectBehavior
{
    public function it_can_get_a_specific_event()
    {
        $this
            ->start();
        $this
            ->checkpoint('foo');

        $this
            ->getEvent('foo')
            ->shouldBeArray();

        $this
            ->shouldThrow(Exception::class)
            ->duringGetEvent('bar');
    }

    public function it_can_get_all_events()
    {
        $this
            ->getAll()
            ->shouldHaveCount(1);

        $this
            ->start();

        $this
            ->checkpoint();
        $this
            ->checkpoint();
        $this
            ->checkpoint();

        $this
            ->stop();

        $this
            ->getAll()
            ->shouldHaveCount(6);
    }

    public function it_can_get_diffs_from_start_to_stop()
    {
        sleep(1);
        $this
            ->start();
        sleep(1);
        $this
            ->checkpoint();
        sleep(1);
        $this
            ->stop();

        $this
            ->getStartToStopDuration()
            ->asMillisecond()
            ->shouldBeApproximately(2000, 250);
    }

    public function it_can_get_elapsed_time()
    {
        $this
            ->start();

        sleep(1);

        $this
            ->getElapsed()
            ->asMillisecond()
            ->shouldBeApproximately(1000, 250);

        $this
            ->stop();

        $this
            ->shouldThrow(LogicException::class)
            ->duringGetElapsed();
    }

    public function it_can_get_last_diff()
    {
        $this->start();

        $this
            ->checkpoint()
            ->getLastDiff()
            ->asMillisecond()
            ->shouldBeFloat();

        $this
            ->getAll()
            ->shouldHaveCount(3);
    }

    public function it_is_able_to_add_checkpoints()
    {
        $this
            ->shouldThrow(LogicException::class)
            ->duringCheckpoint();

        $this->start();

        sleep(1);

        $this
            ->checkpoint('foo')
            ->getDiffFromTo('start', 'foo')
            ->asMillisecond()
            ->shouldBeApproximately(1000, 500);

        $this
            ->shouldThrow(InvalidArgumentException::class)
            ->duringCheckpoint('construct');

        $this
            ->shouldThrow(InvalidArgumentException::class)
            ->duringCheckpoint('start');

        $this
            ->shouldThrow(InvalidArgumentException::class)
            ->duringCheckpoint('stop');

        $this
            ->stop();

        $this
            ->shouldThrow(LogicException::class)
            ->duringCheckpoint('foo');
    }

    public function it_is_able_to_get_diff_between_two_events()
    {
        $this
            ->start();

        sleep(1);

        $this->checkpoint();

        $this
            ->getDiffFromTo('construct', 'start')
            ->asMillisecond()
            ->shouldBeApproximately(0, 500);

        $this
            ->getDiffFromTo('construct', 2)
            ->asMillisecond()
            ->shouldBeApproximately(1000, 500);

        $this
            ->shouldThrow(InvalidArgumentException::class)
            ->duringGetDiffFromTo('construct', 'foo');
    }

    public function it_is_able_to_get_last_diff()
    {
        $this
            ->start();

        sleep(1);

        $this->checkpoint();

        $this
            ->getDiff(0)
            ->asMillisecond()
            ->shouldBeApproximately(1000, 500);

        sleep(2);
        $this->checkpoint();

        $this
            ->getDiff(1)
            ->asMillisecond()
            ->shouldBeApproximately(2000, 500);

        $this->stop();

        $this
            ->getStartToStopDuration()
            ->asMillisecond()
            ->shouldBeApproximately(3000, 500);
    }

    public function it_is_able_to_get_the_diff_between_start_and_stop()
    {
        $this
            ->start();

        sleep(1);

        $this
            ->stop();

        $this
            ->getStartToStopDuration()
            ->asMillisecond()
            ->shouldBeFloat();

        $this
            ->getStartToStopDuration()
            ->asMillisecond()
            ->shouldBeApproximately(1000, 250);
    }

    public function it_is_able_to_get_the_start_time()
    {
        $this
            ->shouldThrow(LogicException::class)
            ->duringGetStartTime();

        $this
            ->start();

        $this
            ->getStartTime()
            ->shouldBeAnInstanceOf(TimeInterface::class);
    }

    public function it_is_able_to_get_the_stop_time()
    {
        $this
            ->shouldThrow(LogicException::class)
            ->duringGetStopTime();

        $this
            ->start();

        $this
            ->stop();

        $this
            ->getStopTime()
            ->shouldBeAnInstanceOf(TimeInterface::class);
    }

    public function it_is_able_to_starts()
    {
        $this
            ->isStarted()
            ->shouldReturn(false);

        $this
            ->start();

        $this
            ->isStarted()
            ->shouldReturn(true);

        $this
            ->shouldThrow(LogicException::class)
            ->duringStart();

        $this
            ->stop();

        $this
            ->getStartToStopDuration()
            ->asMillisecond()
            ->shouldBeApproximately(0, 250);
    }

    public function it_is_able_to_stops()
    {
        $this
            ->isStopped()
            ->shouldReturn(false);

        $this
            ->shouldThrow(LogicException::class)
            ->duringStop();

        $this
            ->isStopped()
            ->shouldReturn(false);

        $this
            ->start();

        $this
            ->stop();

        $this
            ->isStopped()
            ->shouldReturn(true);

        $this
            ->shouldThrow(LogicException::class)
            ->duringStop();

        $this
            ->getStartToStopDuration()
            ->asMillisecond()
            ->shouldBeApproximately(0, 250);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Stopwatch::class);

        $this
            ->getConstructTime()
            ->asMillisecond()
            ->shouldBeFloat();

        $this
            ->isStarted()
            ->shouldReturn(false);

        $this
            ->isStopped()
            ->shouldReturn(false);
    }

    public function let()
    {
        $this
            ->beConstructedWith(new HrClock());
    }
}
