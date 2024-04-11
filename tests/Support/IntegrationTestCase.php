<?php

declare(strict_types=1);

namespace Tests\Support;

use WebTheory\UnitUtils\Concerns\AssertionsTrait;
use WebTheory\UnitUtils\Concerns\FakeGeneratorTrait;
use WebTheory\UnitUtils\Concerns\FormattedDataSetsTrait;
use WebTheory\UnitUtils\Concerns\MockeryTrait;
use WebTheory\UnitUtils\Concerns\ProphecyTrait;
use WebTheory\UnitUtils\Concerns\SystemTrait;
use WebTheory\WpTest\WpLoadedTestCase;

abstract class IntegrationTestCase extends WpLoadedTestCase
{
    use AssertionsTrait;
    use FakeGeneratorTrait;
    use FormattedDataSetsTrait;
    use MockeryTrait;
    use ProphecyTrait;
    use SystemTrait;

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
