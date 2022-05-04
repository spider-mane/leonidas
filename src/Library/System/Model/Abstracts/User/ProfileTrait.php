<?php

namespace Leonidas\Library\System\Model\Abstracts\User;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Leonidas\Library\System\Model\Link\WebPage;
use Psr\Link\LinkInterface;
use WP_User;

trait ProfileTrait
{
    protected WP_User $user;

    protected LinkInterface $url;

    protected CarbonInterface $dateRegistered;

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

    public function getNicename(): string
    {
        return $this->user->user_nicename;
    }

    public function getEmail(): string
    {
        return $this->user->user_email;
    }

    public function getUrl(): LinkInterface
    {
        return $this->url ??= new WebPage($this->user->user_url);
    }

    public function getDateRegistered(): CarbonInterface
    {
        return $this->dateRegistered ??= new Carbon($this->user->user_registered);
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

    public function toArray(): array
    {
        return (array) $this->user->data;
    }
}
