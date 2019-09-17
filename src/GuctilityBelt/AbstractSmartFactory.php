<?php

namespace Backalley\GuctilityBelt;

use Backalley\GuctilityBelt\Concerns\ClassResolverTrait;
use Backalley\GuctilityBelt\Concerns\SmartFactoryTrait;
use Backalley\GuctilityBelt\Contracts\SmartFactoryInterface;

abstract class AbstractSmartFactory implements SmartFactoryInterface
{
    use SmartFactoryTrait;
    use ClassResolverTrait;

    /**
     *
     */
    protected $namespaces = [];

    /**
     *
     */
    public const NAMESPACES = [];

    /**
     *
     */
    private const CONVENTION = null;

    /**
     *
     */
    public function __construct(string ...$namespaces)
    {
        $this->namespaces = $namespaces + static::NAMESPACES;
    }
}
