<?php

declare(strict_types=1);

namespace Tests\Support;

abstract class UnitTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
