<?php

namespace Leonidas\Library\System\Model\Abstracts\User;

use DateTimeInterface;
use Leonidas\Contracts\System\Schema\User\UserEntityManagerInterface;
use Psr\Link\LinkInterface;

trait MutableUserModelTrait
{
    use UserModelTrait;

    public function setNickname(string $nickname): self
    {
        $this->user->nickname = $nickname;

        return $this;
    }

    public function setBio(string $bio): self
    {
        $this->user->description = $bio;

        return $this;
    }

    public function setFirstName(string $firstName): self
    {
        $this->user->first_name = $firstName;

        return $this;
    }

    public function setLastName(string $lastName): self
    {
        $this->user->last_name = $lastName;

        return $this;
    }

    public function setLogin(string $login): self
    {
        $this->user->user_login = $login;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->user->user_pass = $password;

        return $this;
    }

    public function setNicename(string $nicename): self
    {
        $this->user->user_nicename = $nicename;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->user->user_email = $email;

        return $this;
    }

    public function setUrl(LinkInterface $url): self
    {
        $this->user->user_url = $url->getHref();

        return $this;
    }

    public function setDateRegistered(DateTimeInterface $registered): self
    {
        $this->user->user_registered = $registered->format(
            UserEntityManagerInterface::DATE_FORMAT
        );

        return $this;
    }

    public function setActivationKey(string $activationKey): self
    {
        $this->user->user_activation_key = $activationKey;

        return $this;
    }

    public function setDisplayName(string $displayName): self
    {
        $this->user->display_name = $displayName;

        return $this;
    }

    public function setIsSpam(bool $isSpam): self
    {
        $this->user->spam = (string) $isSpam;

        return $this;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->user->deleted = (string) $isDeleted;

        return $this;
    }

    public function setLocale(string $local): self
    {
        $this->user->locale = $local;

        return $this;
    }

    public function setUseSsl(bool $useSsl): self
    {
        $this->user->use_ssl = (string) $useSsl;

        return $this;
    }

    public function setOption(string $option, $value): self
    {
        $this->user->__set($option, $value);

        return $this;
    }

    public function setAssociatedSite(int $siteId): self
    {
        $this->user->for_site($siteId);

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
}
