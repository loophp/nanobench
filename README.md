[![Latest Stable Version][latest stable version]][packagist]
[![GitHub stars][github stars]][packagist]
[![Total Downloads][total downloads]][packagist]
[![GitHub Workflow Status][github workflow status]][github actions]
[![Scrutinizer code quality][code quality]][code quality link]
[![Type Coverage][type coverage]][sheperd type coverage]
[![Code Coverage][code coverage]][code quality link]
[![License][license]][packagist]
[![Donate!][donate github]][github sponsor]
[![Donate!][donate paypal]][paypal sponsor]

# PHP Nanobench

A simple and lightweight benchmarking tool for PHP.

## Installation

`composer require loophp/nanobench`

## Usage

```php
<?php

declare(strict_types=1);

namespace App;

use loophp\nanobench\Benchmark;
use loophp\nanobench\Time\HrClock;
use loophp\nanobench\Time\Stopwatch;

include __DIR__ . '/vendor/autoload.php';

$callable = static function (int $secondsToWait): int {
    sleep($secondsToWait);

    return $secondsToWait ** 2;
};

$benchmark = new Benchmark(new Stopwatch(new HrClock()), $callable, 3);
$duration = $benchmark->run()->getDuration();

$duration->asNanosecond();
$duration->asMicrosecond();
$duration->asMillisecond();
$duration->asSecond();

$benchmark->getReturn(); // Return value of the callable that has been benchmarked
```

## Documentation

### API

The API is quite light and completely described in the [Benchmark interface][benchmark interface].

## Code quality, tests and benchmarks

Every time changes are introduced into the library, [Github][github actions] run the
tests.

The library has tests written with [PHPSpec][phpspec].
Feel free to check them out in the `spec` directory. Run `composer phpspec` to trigger the tests.

Before each commit some inspections are executed with [GrumPHP][grumphp],
run `composer grumphp` to check manually.

The quality of the tests is tested with [Infection][infection] a PHP Mutation testing
framework, run `composer infection` to try it.

Static analysers are also controlling the code. [PHPStan][phpstan] and
[PSalm][psalm] are enabled to their maximum level.

## Contributing

Feel free to contribute by sending Github pull requests. I'm quite reactive :-)

If you can't contribute to the code, you can also sponsor me on [Github][github sponsor] or [Paypal][paypal sponsor].

## Changelog

See [CHANGELOG.md][changelog-md] for a changelog based on [git commits][git-commits].

For more detailed changelogs, please check [the release changelogs][changelog-releases].

[latest stable version]: https://img.shields.io/packagist/v/loophp/nanobench.svg?style=flat-square
[packagist]: https://packagist.org/packages/loophp/nanobench
[github stars]: https://img.shields.io/github/stars/loophp/nanobench.svg?style=flat-square
[total downloads]: https://img.shields.io/packagist/dt/loophp/nanobench.svg?style=flat-square
[github workflow status]: https://img.shields.io/github/workflow/status/loophp/nanobench/Continuous%20Integration?style=flat-square
[github actions]: https://github.com/loophp/nanobench/actions
[code quality]: https://img.shields.io/scrutinizer/quality/g/loophp/nanobench/master.svg?style=flat-square
[code quality link]: https://scrutinizer-ci.com/g/loophp/nanobench/?branch=master
[type coverage]: https://shepherd.dev/github/loophp/nanobench/coverage.svg
[sheperd type coverage]: https://shepherd.dev/github/loophp/nanobench
[code coverage]: https://img.shields.io/scrutinizer/coverage/g/loophp/nanobench/master.svg?style=flat-square
[code quality link]: https://img.shields.io/scrutinizer/quality/g/loophp/nanobench/master.svg?style=flat-square
[license]: https://img.shields.io/packagist/l/loophp/nanobench.svg?style=flat-square
[donate github]: https://img.shields.io/badge/Sponsor-Github-brightgreen.svg?style=flat-square
[github sponsor]: https://github.com/sponsors/drupol
[donate paypal]: https://img.shields.io/badge/Sponsor-Paypal-brightgreen.svg?style=flat-square
[paypal sponsor]: https://www.paypal.me/drupol
[phpspec]: http://www.phpspec.net/
[grumphp]: https://github.com/phpro/grumphp
[infection]: https://github.com/infection/infection
[phpstan]: https://github.com/phpstan/phpstan
[psalm]: https://github.com/vimeo/psalm
[changelog-md]: https://github.com/loophp/nanobench/blob/master/CHANGELOG.md
[git-commits]: https://github.com/loophp/nanobench/commits/master
[changelog-releases]: https://github.com/loophp/nanobench/releases
[phpunit php-timer]: https://github.com/phpunit/php-timer
[benchmark interface]: https://github.com/loophp/nanobench/blob/master/src/BenchmarkInterface.php
