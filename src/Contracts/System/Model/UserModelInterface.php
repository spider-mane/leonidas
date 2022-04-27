<?php

namespace Leonidas\Contracts\System\Model;

interface UserModelInterface extends EntityModelInterface
{
    public function getAssociatedSite(): int;

    public function getRoles(): array;

    public function getCapabilities(): array;

    public function getCapabilityKey(): string;

    public function hasCapability(string $capability, ...$args): bool;

    public function getAllCapabilities(): array;

    /**
     * @return bool[]
     */
    public function getCapabilityData(): array;
}
