<?php

namespace Leonidas\Contracts\System\Model\User;

use Leonidas\Contracts\System\Model\Profile\ProfileInterface;

interface UserInterface
{
    public function getId(): int;

    public function getProfile(): ProfileInterface;

    public function getAssociatedSite(): int;

    public function setAssociatedSite(int $siteId): void;

    public function getRoles(): array;

    public function addRole(string $role): void;

    public function removeRole(string $role): void;

    public function setRole(string $role): void;

    public function getCapabilities(): array;

    public function getCapabilityKey(): string;

    public function addCapability(string $capability): void;

    public function removeCapability(string $capability): void;

    public function removeAllCapabilities(): void;

    public function hasCapability(string $capability, ...$args): bool;

    public function getAllCapabilities(): array;

    /**
     * @return bool[]
     */
    public function getCapabilityData(): array;
}
