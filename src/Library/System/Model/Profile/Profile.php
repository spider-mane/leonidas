<?php

namespace Leonidas\Library\System\Model\Profile;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Leonidas\Contracts\System\Model\Profile\ProfileInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Library\System\Model\Link\WebPage;
use Leonidas\Library\System\Model\User\User;
use Psr\Link\LinkInterface;
use WP_User;

class Profile implements ProfileInterface
{
    protected WP_User $user;

    public function __construct(WP_User $user)
    {
        $this->user = $user;
    }

    public function getUser(): UserInterface
    {
        return new User($this->user);
    }

    public function getNickname(): string
    {
        return $this->user->nickname;
    }

    public function getBio(): string
    {
        return $this->user->description;
    }

    public function getFirstName(): string
    {
        return $this->user->first_name;
    }

    public function getLastName(): string
    {
        return $this->user->last_name;
    }

    public function getLogin(): string
    {
        return $this->user->user_login;
    }

    public function getPassword(): string
    {
        return $this->user->user_pass;
    }

    public function getNameSlug(): string
    {
        return $this->user->user_nicename;
    }

    public function getEmail(): string
    {
        return $this->user->user_email;
    }

    public function getUrl(): LinkInterface
    {
        return new WebPage($this->user->user_url);
    }

    public function getDateRegistered(): CarbonInterface
    {
        return new Carbon($this->user->user_registered);
    }

    public function getActivationKey(): string
    {
        return $this->user->user_activation_key;
    }

    public function getDisplayName(): string
    {
        return $this->user->display_name;
    }

    public function isSpam(): ?bool
    {
        return $this->user->spam;
    }

    public function isDeleted(): bool
    {
        return $this->user->deleted;
    }

    public function getLocale(): string
    {
        return $this->user->locale;
    }

    public function useSsl(): bool
    {
        return $this->user->use_ssl;
    }

    public function getOptions(): array
    {
        return (array) $this->user->data;
    }

    public function getOption(string $option): string
    {
        return $this->user->get($option);
    }

    public function hasOption(string $option): bool
    {
        return $this->user->has_prop($option);
    }

    public function setOption(string $option, $value): void
    {
        $this->user->set($option, $value);
    }

    public function setFilter(string $filter): void
    {
        $this->user->filter = $filter;
    }

    public function getFilter(): string
    {
        return $this->user->filter;
    }
}
