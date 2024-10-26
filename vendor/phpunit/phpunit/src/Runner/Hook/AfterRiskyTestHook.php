<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Util\Xml;

/**
<<<<<<<< HEAD:vendor/phpunit/phpunit/src/Util/Xml/FailedSchemaDetectionResult.php
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 *
 * @psalm-immutable
 */
final class FailedSchemaDetectionResult extends SchemaDetectionResult
========
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise for PHPUnit
 */
interface AfterRiskyTestHook extends TestHook
>>>>>>>> master:vendor/phpunit/phpunit/src/Runner/Hook/AfterRiskyTestHook.php
{
    public function executeAfterRiskyTest(string $test, string $message, float $time): void;
}
