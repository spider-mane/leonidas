<?php

declare(strict_types=1);

namespace Tests\Support\Concerns;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;

trait MockeryTrait
{
    use MockeryPHPUnitIntegration;

    protected function makeMockeryOf($class, string ...$interfaces): MockInterface|LegacyMockInterface
    {
        return Mockery::mock($class, ...$interfaces);
    }

    protected function closeMockery(): void
    {
        Mockery::close();
    }
}
