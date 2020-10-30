<?php

declare(strict_types=1);

namespace loophp\nanobench\Time;

interface StopwatchInterface
{
    public function checkpoint($name = null): self;

    public function getDiffFromTo($from, $to): TimeInterface;

    public function getElapsed(): TimeInterface;

    public function isStarted(): bool;

    public function isStopped(): bool;

    public function reset(): self;

    public function start(): self;

    public function stop(): void;
}
