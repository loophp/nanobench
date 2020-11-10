<?php

declare(strict_types=1);

namespace loophp\nanobench\Time;

interface StopwatchInterface
{
    /**
     * @param mixed $id
     */
    public function checkpoint($id = null): StopwatchInterface;

    /**
     * @param mixed $from
     * @param mixed $to
     */
    public function getDiffFromTo($from, $to): TimeInterface;

    public function getElapsed(): TimeInterface;

    public function isStarted(): bool;

    public function isStopped(): bool;

    public function reset(): StopwatchInterface;

    public function start(): StopwatchInterface;

    public function stop(): void;
}
