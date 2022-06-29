<?php

declare(strict_types=1);

namespace Tests\Support;

use Tests\Support\Concerns\FakerTrait;
use Tests\Support\Concerns\HelperTrait;
use Tests\Support\Concerns\MockeryTrait;
use Tests\Support\Concerns\ProphecyTrait;
use WebTheory\WpTest\WpLoadedTestCase;

abstract class IntegrationTestCase extends WpLoadedTestCase
{
    use FakerTrait;
    use HelperTrait;
    use MockeryTrait;
    use ProphecyTrait;

    protected string $root;

    public function setUp(): void
    {
        parent::setUp();

        $this->root = dirname(__DIR__, 2);

        $this->initFaker();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->closeMockery();
    }
}
