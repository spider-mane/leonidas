<?php

namespace WebTheory\GuctilityBelt\Contracts;

interface SmartFactoryInterface
{
    /**
     *
     */
    public function addNamespaces(array $namespaces);

    /**
     *
     */
    public function addNamespace(string $namespace);

    /**
     *
     */
    public function getNamespaces(): array;
}
