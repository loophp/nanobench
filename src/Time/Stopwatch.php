<?php

declare(strict_types=1);

namespace loophp\nanobench\Time;

use InvalidArgumentException;
use LogicException;
use loophp\collection\Collection;
use loophp\collection\Contract\Collection as ContractCollection;

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

    public function checkpoint($name = null): self
    {
        $time = $this->clock->time();

        if (true === in_array($name, ['start', 'construct', 'stop'], true)) {
            throw new InvalidArgumentException('Invalid checkpoint id.');
        }

        if (false === $this->isStarted()) {
            throw new LogicException('Cannot add a checkpoint in a stopwatch that has not started yet.');
        }

        if (true === $this->isStopped()) {
            throw new LogicException('Cannot add a checkpoint in a stopped stopwatch.');
        }

        $this->events[] = [$time, $name];

        return $this;
    }

    public function getAll(): array
    {
        return $this->getEvents()->all();
    }

    public function getConstructTime(): TimeInterface
    {
        $event = $this->getEvent('construct');

        return $event[0];
    }

    public function getDiff(): TimeInterface
    {
        return $this
            ->getDiffs()
            ->last()
            ->current();
    }

    public function getDiffFromTo($from, $to): TimeInterface
    {
        $events = $this
            ->getEvents()
            ->filter(static fn (array $event): bool => in_array($event[1], [$from, $to], true));

        if (2 !== $events->count()) {
            throw new InvalidArgumentException('Unable to find the events.');
        }

        return $events
            ->map(static fn (array $event) => $event[0])
            ->foldLeft1(static fn (TimeInterface $one, TimeInterface $two): TimeInterface => new Duration($one, $two))
            ->current();
    }

    public function getElapsed(): TimeInterface
    {
        $time = $this->clock->time();

        if (true === $this->isStopped()) {
            throw new LogicException('Cannot get elapsed time an already stopped stopwatch.');
        }

        return new Duration(
            $this
                ->getEvents()
                ->since(static fn (array $event): bool => 'start' === $event[1])
                ->until(static fn (array $event): bool => 'stop' === $event[1])
                ->last()
                ->unwrap()
                ->current(),
            $time
        );
    }

    public function getEvent($id): array
    {
        $event = $this
            ->getEvents()
            ->filter(
                static function (array $event) use ($id): bool {
                    return $event[1] === $id;
                }
            )
            ->current();

        if (null === $event) {
            throw new InvalidArgumentException(sprintf('Unable to find event: %s', $id));
        }

        return $event;
    }

    public function getLastDiff(): TimeInterface
    {
        return $this
            ->getDiffs()
            ->last()
            ->current();
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
        return 0 !== $this
            ->getEvents()
            ->filter(
                static function (array $v): bool {
                    return 'start' === $v[1];
                }
            )
            ->count();
    }

    public function isStopped(): bool
    {
        return 0 !== $this
            ->getEvents()
            ->filter(
                static function (array $v): bool {
                    return 'stop' === $v[1];
                }
            )
            ->count();
    }

    public function reset(): self
    {
        $this->events = [array_shift($this->events)];

        return $this;
    }

    public function start(): self
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

    private function getDiffs(): ContractCollection
    {
        return $this
            ->getEvents()
            ->since(static fn (array $event): bool => 'start' === $event[1])
            ->until(static fn (array $event): bool => 'stop' === $event[1])
            ->normalize()
            ->window(1)
            ->drop(1)
            ->map(
                static function (array $v): Duration {
                    return new Duration($v[0][0], $v[1][0]);
                }
            );
    }

    private function getEvents(): Collection
    {
        return Collection::fromIterable($this->events)
            ->map(
                static function (array $event, int $key): array {
                    $event[1] = $event[1] ?? $key;

                    return $event;
                }
            );
    }
}
