<?php

namespace Leonidas\Library\System\Model\Abstracts\User;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Leonidas\Library\System\Model\Link\WebPage;
use Psr\Link\LinkInterface;
use WP_User;

trait UserModelTrait
{
    protected WP_User $user;

    public function getId(): int
    {
        return $this->user->ID;
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
        return (bool) $this->user->spam;
    }

    public function isDeleted(): bool
    {
        return (bool) $this->user->deleted;
    }

    public function getLocale(): string
    {
        return $this->user->locale;
    }

    public function useSsl(): bool
    {
        return (bool) $this->user->use_ssl;
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

    public function getAssociatedSite(): int
    {
        return $this->user->get_site_id();
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
