<?php

declare(strict_types=1);

namespace loophp\nanobench\Time;

use InvalidArgumentException;
use LogicException;

use function count;
use function in_array;

final class Stopwatch implements StopwatchInterface
{
    /**
     * @var ClockInterface
     */
    private $clock;

    /**
     * @var array
     */
    private $events;

    public function __construct(ClockInterface $clock)
    {
        $clock = $clock;
        $time = $clock->time();

        $this->clock = $clock;
        $this->events = [[$time, 'construct']];
    }

    /**
     * @psalm-param mixed $id
     *
     * @param mixed|null $id
     */
    public function checkpoint($id = null): StopwatchInterface
    {
        $time = $this->clock->time();

        if (true === in_array($id, ['start', 'construct', 'stop'], true)) {
            throw new InvalidArgumentException('Invalid checkpoint id.');
        }

        if (false === $this->isStarted()) {
            throw new LogicException('Cannot add a checkpoint in a stopwatch that has not started yet.');
        }

        if (true === $this->isStopped()) {
            throw new LogicException('Cannot add a checkpoint in a stopped stopwatch.');
        }

        $this->events[] = [$time, $id];

        return $this;
    }

    public function getAll(): array
    {
        return $this->getEvents();
    }

    public function getConstructTime(): TimeInterface
    {
        $event = $this->getEvent('construct');

        return $event[0];
    }

    public function getDiff(): TimeInterface
    {
        $diffs = $this->getDiffs();

        return end($diffs);
    }

    /**
     * @psalm-param mixed $from
     * @psalm-param mixed $to
     *
     * @param mixed $from
     * @param mixed $to
     */
    public function getDiffFromTo($from, $to): TimeInterface
    {
        $events = array_filter(
            $this->getEvents(),
            static function (array $event) use ($from, $to): bool {
                return in_array($event[1], [$from, $to], true);
            }
        );

        if (2 !== count($events)) {
            throw new InvalidArgumentException('Unable to find the events.');
        }

        $fromKey = $this->arrayFind($events, static function (array $event) use ($from): bool {
            return $event[1] === $from;
        });
        $toKey = $this->arrayFind($events, static function (array $event) use ($to): bool {
            return $event[1] === $to;
        });

        return new Duration($events[$fromKey][0], $events[$toKey][0]);
    }

    public function getDiffs(): array
    {
        $events = $this->getEvents();
        // Remove created event.
        array_shift($events);

        $events = array_map(
            static function (array $event): TimeInterface {
                return $event[0];
            },
            $events
        );

        $first = array_shift($events);

        $diffs = [];

        foreach ($events as $event) {
            $diffs[] = new Duration($first, $event);

            $first = $event;
        }

        return $diffs;
    }

    public function getElapsed(): TimeInterface
    {
        $time = $this->clock->time();

        if (true === $this->isStopped()) {
            throw new LogicException('Cannot get elapsed time an already stopped stopwatch.');
        }

        $events = $this->getEvents();
        $event = end($events);

        return new Duration(
            $event[0],
            $time
        );
    }

    /**
     * @psalm-param mixed $id
     *
     * @param mixed $id
     */
    public function getEvent($id): array
    {
        $events = $this->getEvents();

        $events = array_filter(
            $events,
            static function (array $event) use ($id): bool {
                return $event[1] === $id;
            }
        );

        if ([] === $events) {
            throw new InvalidArgumentException(sprintf('Unable to find event: %s', $id));
        }

        return current($events);
    }

    public function getLastDiff(): TimeInterface
    {
        $diffs = $this->getDiffs();

        return end($diffs);
    }

    public function getStartTime(): TimeInterface
    {
        if (false === $this->isStarted()) {
            throw new LogicException('Stopwatch has not started yet.');
        }

        return $this->getEvent('start')[0];
    }

    public function getStartToStopDuration(): TimeInterface
    {
        return $this->getDiffFromTo('start', 'stop');
    }

    public function getStopTime(): TimeInterface
    {
        if (false === $this->isStopped()) {
            throw new LogicException('Stopwatch has not stopped yet.');
        }

        return $this->getEvent('stop')[0];
    }

    public function isStarted(): bool
    {
        return null !== $this
            ->arrayFind(
                $this->getEvents(),
                static function (array $v): bool {
                    return 'start' === $v[1];
                }
            );
    }

    public function isStopped(): bool
    {
        return null !== $this
            ->arrayFind(
                $this->getEvents(),
                static function (array $v): bool {
                    return 'stop' === $v[1];
                }
            );
    }

    public function reset(): StopwatchInterface
    {
        $this->events = [array_shift($this->events)];

        return $this;
    }

    public function start(): StopwatchInterface
    {
        $time = $this->clock->time();

        if (true === $this->isStarted()) {
            throw new LogicException('Cannot start an already started stopwatch.');
        }

        $this->events[] = [$time, 'start'];

        return $this;
    }

    public function stop(): void
    {
        $time = $this->clock->time();

        if (true === $this->isStopped()) {
            throw new LogicException('Cannot stop an already stopped stopwatch.');
        }

        if (false === $this->isStarted()) {
            throw new LogicException('Cannot stop a stopwatch that has not started yet.');
        }

        $this->events[] = [$time, 'stop'];
    }

    private function arrayFind(array $xs, callable $f): ?int
    {
        foreach ($xs as $key => $x) {
            if ($f($x)) {
                return $key;
            }
        }

        return null;
    }

    private function getEvents(): array
    {
        $events = [];

        foreach ($this->events as $key => $event) {
            $event[1] = $event[1] ?? $key;
            $events[] = $event;
        }

        return $events;
    }
}
