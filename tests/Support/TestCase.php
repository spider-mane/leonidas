<?php

declare(strict_types=1);

namespace Tests\Support;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use WebTheory\UnitUtils\Concerns\AssertionsTrait;
use WebTheory\UnitUtils\Concerns\FakeGeneratorTrait;
use WebTheory\UnitUtils\Concerns\FormattedDataSetsTrait;
use WebTheory\UnitUtils\Concerns\MockeryTrait;
use WebTheory\UnitUtils\Concerns\ProphecyTrait;
use WebTheory\UnitUtils\Concerns\SystemTrait;

abstract class TestCase extends PHPUnitTestCase
{
    use AssertionsTrait;
    use FakeGeneratorTrait;
    use FormattedDataSetsTrait;
    use MockeryTrait;
    use ProphecyTrait;
    use SystemTrait;

    protected string $root;

    protected function setUp(): void
    {
        parent::setUp();

        $this->root = dirname(__DIR__, 2);

        $this->initFaker();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->closeMockery();
    }

    protected function getAbspath(string $path = ''): string
    {
        return $this->root . $path;
    }
}
