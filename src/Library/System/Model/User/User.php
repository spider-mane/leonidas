<?php

namespace Leonidas\Library\System\Model\User;

use Leonidas\Contracts\System\Model\Profile\ProfileInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Library\System\Model\Profile\Profile;
use WP_User;

class User implements UserInterface
{
    protected WP_User $user;

    public function __construct(WP_User $user)
    {
        $this->user = $user;
    }

    public function getId(): int
    {
        return $this->user->ID;
    }

    public function getProfile(): ProfileInterface
    {
        return new Profile($this->user);
    }

    public function getAssociatedSite(): int
    {
        return $this->user->site_id;
    }

    public function setAssociatedSite(int $siteId): void
    {
        $this->user->site_id = $siteId;
    }

    public function getRoles(): array
    {
        return $this->user->roles;
    }

    public function addRole(string $role): void
    {
        $this->user->add_role($role);
    }

    public function removeRole(string $role): void
    {
        $this->user->remove_role($role);
    }

    public function setRole(string $role): void
    {
        $this->user->set_role($role);
    }

    public function getCapabilities(): array
    {
        return $this->user->caps;
    }

    public function getAllCapabilities(): array
    {
        return $this->user->allcaps;
    }

    public function getCapabilityKey(): string
    {
        return $this->user->cap_key;
    }

    public function getCapabilityData(): array
    {
        return $this->user->cap_data;
    }

    public function hasCapability(string $capability, ...$args): bool
    {
        return $this->user->has_cap($capability, ...$args);
    }

    public function addCapability(string $capability): void
    {
        $this->user->add_cap($capability);
    }

    public function removeCapability(string $capability): void
    {
        $this->user->remove_cap($capability);
    }

    public function removeAllCapabilities(): void
    {
        $this->user->remove_all_caps();
    }
}
