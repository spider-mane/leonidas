<?php

namespace WebTheory\GuctilityBelt;

use WebTheory\GuctilityBelt\Concerns\ClassResolverTrait;
use WebTheory\GuctilityBelt\Concerns\SmartFactoryTrait;
use WebTheory\GuctilityBelt\Contracts\SmartFactoryInterface;

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
