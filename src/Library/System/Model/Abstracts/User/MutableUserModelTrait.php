<?php

namespace Leonidas\Library\System\Model\Abstracts\User;

use Leonidas\Contracts\System\Model\ProfileInterface;
use WP_User;

trait MutableUserModelTrait
{
    use UserModelTrait;

    protected WP_User $user;

    public function setAssociatedSite(int $siteId): self
    {
        $this->user->site_id = $siteId;

        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->user->roles = $roles;

        return $this;
    }

    public function addRole(string $role): self
    {
        $this->user->add_role($role);

        return $this;
    }

    public function removeRole(string $role): self
    {
        $this->user->remove_role($role);

        return $this;
    }

    public function setRole(string $role): self
    {
        $this->user->set_role($role);

        return $this;
    }

    public function setCapabilities(array $capabilities): self
    {
        $this->user->caps = $capabilities;

        return $this;
    }

    public function setCapabilityKey(string $capKey): self
    {
        $this->user->cap_key = $capKey;

        return $this;
    }

    public function addCapability(string $capability): self
    {
        $this->user->add_cap($capability);

        return $this;
    }

    public function removeCapability(string $capability): self
    {
        $this->user->remove_cap($capability);

        return $this;
    }

    public function removeAllCapabilities(): void
    {
        $this->user->remove_all_caps();
    }

    protected function assignProfileToUser(ProfileInterface $profile): self
    {
        foreach ($profile->toArray() as $name => $value) {
            $this->user->{$name} = $value;
        }

        return $this;
    }
}
