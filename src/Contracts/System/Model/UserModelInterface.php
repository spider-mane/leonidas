<?php

namespace Leonidas\Contracts\System\Model;

use DateTimeInterface;
use Psr\Link\LinkInterface;

interface UserModelInterface extends EntityModelInterface
{
    public function getLogin(): string;

    public function getPassword(): string;

    public function getEmail(): string;

    public function getNicename(): string;

    public function getDisplayName(): string;

    public function getDateRegistered(): DateTimeInterface;

    public function getBio(): string;

    public function getNickname(): string;

    public function getFirstName(): string;

    public function getLastName(): string;

    public function getUrl(): LinkInterface;

    public function isSpam(): ?bool;

    public function isDeleted(): bool;

    public function getLocale(): string;

    public function useSsl(): bool;

    public function getOptions(): array;

    public function getOption(string $option);

    public function hasOption(string $option): bool;

    public function getActivationKey(): string;

    public function getAssociatedSite(): int;

    public function getRoles(): array;

    public function getCapabilities(): array;

    public function getCapabilityKey(): string;

    public function hasCapability(string $capability, ...$args): bool;

    public function getAllCapabilities(): array;
}
