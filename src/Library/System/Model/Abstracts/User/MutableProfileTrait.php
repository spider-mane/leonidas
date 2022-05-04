<?php

namespace Leonidas\Library\System\Model\Abstracts\User;

use DateTimeInterface;
use Psr\Link\LinkInterface;

trait MutableProfileTrait
{
    use ProfileTrait;

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

    public function setUrl(LinkInterface $nickname): self
    {
        $this->url = $nickname;

        return $this;
    }

    public function setDateRegistered(DateTimeInterface $registered): self
    {
        $this->dateRegistered = $registered;

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
        $this->user->spam = $isSpam;

        return $this;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->user->deleted = $isDeleted;

        return $this;
    }

    public function setLocale(string $nickname): self
    {
        $this->user->locale = $nickname;

        return $this;
    }

    public function setUseSsl(bool $useSsl): self
    {
        $this->user->use_ssl = $useSsl;

        return $this;
    }

    public function setOption(string $option, $value): self
    {
        $this->user->__set($option, $value);

        return $this;
    }
}
