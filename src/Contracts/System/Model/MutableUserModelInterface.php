<?php

namespace Leonidas\Contracts\System\Model;

interface MutableUserModelInterface extends UserModelInterface
{
    public function setAssociatedSite(int $site): self;

    public function setRoles(array $roles): self;

    public function addRole(string $role): self;

    public function removeRole(string $role): self;

    public function setCapabilities(array $capabilities): self;

    public function setCapabilityKey(string $capKey): self;

    public function addCapability(string $capability): self;

    public function removeCapability(string $capability): self;

    public function removeAllCapabilities(): void;
}
