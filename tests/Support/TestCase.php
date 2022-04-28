<?php

declare(strict_types=1);

namespace Tests\Support;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Tests\Support\Concerns\FakerTrait;
use Tests\Support\Concerns\HelperTrait;
use Tests\Support\Concerns\MockeryTrait;
use Tests\Support\Concerns\ProphecyTrait;

abstract class TestCase extends PHPUnitTestCase
{
    use FakerTrait;
    use HelperTrait;
    use MockeryTrait;
    use ProphecyTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $this->initFaker();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->closeMockery();
    }
}
