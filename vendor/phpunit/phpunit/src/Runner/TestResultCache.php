<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Runner;

/**
<<<<<<<< HEAD:vendor/phpunit/phpunit/src/Runner/Hook/Hook.php
 * This interface, as well as the associated mechanism for extending PHPUnit,
 * will be removed in PHPUnit 10. There is no alternative available in this
 * version of PHPUnit.
 *
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise for PHPUnit
 *
 * @see https://github.com/sebastianbergmann/phpunit/issues/4676
 */
interface Hook
========
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
interface TestResultCache
>>>>>>>> master:vendor/phpunit/phpunit/src/Runner/TestResultCache.php
{
    public function setState(string $testName, int $state): void;

    public function getState(string $testName): int;

    public function setTime(string $testName, float $time): void;

    public function getTime(string $testName): float;

    public function load(): void;

    public function persist(): void;
}
