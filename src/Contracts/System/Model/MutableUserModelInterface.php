<?php

namespace Leonidas\Contracts\System\Model;

use DateTimeInterface;
use Psr\Link\LinkInterface;

interface MutableUserModelInterface extends UserModelInterface
{
    public function setNickname(string $nickname): self;

    public function setBio(string $bio): self;

    public function setFirstName(string $firstName): self;

    public function setLastName(string $lastName): self;

    public function setLogin(string $login): self;

    public function setPassword(string $password): self;

    public function setNicename(string $nicename): self;

    public function setEmail(string $email): self;

    public function setUrl(LinkInterface $url): self;

    public function setDateRegistered(DateTimeInterface $dateRegistered): self;

    public function setActivationKey(string $activationKey): self;

    public function setDisplayName(string $displayName): self;

    public function setIsSpam(bool $isSpam): self;

    public function setIsDeleted(bool $isSpam): self;

    public function setLocale(string $locale): self;

    public function setUseSsl(bool $useSsl): self;

    public function setOption(string $option, $value): self;

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
