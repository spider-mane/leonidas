<?php

namespace Leonidas\Library\System\Model\Abstracts\User;

use WP_User;

trait UserModelTrait
{
    protected WP_User $user;

    public function getId(): int
    {
        return $this->user->ID;
    }

    public function getAssociatedSite(): int
    {
        return $this->user->site_id;
    }

    public function getRoles(): array
    {
        return $this->user->roles;
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

    public function getFilter(): string
    {
        return $this->user->filter;
    }

    public function setFilter(string $filter): self
    {
        $this->user->filter = $filter;

        return $this;
    }
}
