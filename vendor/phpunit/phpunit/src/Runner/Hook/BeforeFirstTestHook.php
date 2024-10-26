<?php declare(strict_types=1);
/*
 * This file is part of sebastian/recursion-context.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
<<<<<<<< HEAD:vendor/sebastian/recursion-context/src/InvalidArgumentException.php
namespace SebastianBergmann\RecursionContext;

final class InvalidArgumentException extends \InvalidArgumentException implements Exception
========
namespace PHPUnit\Runner;

/**
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise for PHPUnit
 */
interface BeforeFirstTestHook extends Hook
>>>>>>>> master:vendor/phpunit/phpunit/src/Runner/Hook/BeforeFirstTestHook.php
{
    public function executeBeforeFirstTest(): void;
}
