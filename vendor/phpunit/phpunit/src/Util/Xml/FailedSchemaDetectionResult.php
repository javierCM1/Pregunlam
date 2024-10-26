<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
<<<<<<<< HEAD:vendor/phpunit/phpunit/src/Framework/MockObject/Exception/ConfigurableMethodsAlreadyInitializedException.php
namespace PHPUnit\Framework\MockObject;
========
namespace PHPUnit\Util\Xml;
>>>>>>>> master:vendor/phpunit/phpunit/src/Util/Xml/FailedSchemaDetectionResult.php

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 *
 * @psalm-immutable
 */
<<<<<<<< HEAD:vendor/phpunit/phpunit/src/Framework/MockObject/Exception/ConfigurableMethodsAlreadyInitializedException.php
final class ConfigurableMethodsAlreadyInitializedException extends \PHPUnit\Framework\Exception implements Exception
========
final class FailedSchemaDetectionResult extends SchemaDetectionResult
>>>>>>>> master:vendor/phpunit/phpunit/src/Util/Xml/FailedSchemaDetectionResult.php
{
}
