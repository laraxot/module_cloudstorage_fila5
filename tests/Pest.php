<?php

declare(strict_types=1);
use Modules\CloudStorage\Tests\TestCase;

/*
 * Bootstrap Pest — modulo CloudStorage.
 * Ogni file test dichiara uses(\Modules\CloudStorage\Tests\TestCase::class).
 */

pest()->extend(TestCase::class)->in(__DIR__.'/Unit', __DIR__.'/Feature');
