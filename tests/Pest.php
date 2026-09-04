<?php

declare(strict_types=1);

/*
 * Bootstrap Pest — modulo CloudStorage.
 * Ogni file test dichiara uses(\Modules\CloudStorage\Tests\TestCase::class).
 */

pest()->extend(\Modules\CloudStorage\Tests\TestCase::class)->in(__DIR__.'/Unit', __DIR__.'/Feature');
