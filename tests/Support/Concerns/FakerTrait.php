<?php

declare(strict_types=1);

namespace Tests\Support\Concerns;

use Faker\Factory;
use Faker\Generator;
use Faker\UniqueGenerator;

trait FakerTrait
{
    protected Generator $fake;

    protected UniqueGenerator $unique;

    protected function initFaker(): void
    {
        $this->fake = $this->createFaker();
        $this->unique = $this->fake->unique(); // @phpstan-ignore-line
    }

    protected function createFaker(): Generator
    {
        return Factory::create();
    }
}
