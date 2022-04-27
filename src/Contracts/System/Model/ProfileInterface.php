<?php

namespace Leonidas\Contracts\System\Model;

use DateTimeInterface;
use Psr\Link\LinkInterface;

interface ProfileInterface
{
    public function getNickname(): string;

    public function getBio(): string;

    public function getFirstName(): string;

    public function getLastName(): string;

    public function getLogin(): string;

    public function getPassword(): string;

    public function getNicename(): string;

    public function getEmail(): string;

    public function getUrl(): LinkInterface;

    public function getDateRegistered(): DateTimeInterface;

    public function getActivationKey(): string;

    public function getDisplayName(): string;

    public function isSpam(): ?bool;

    public function isDeleted(): bool;

    public function getLocale(): string;

    public function useSsl(): bool;

    public function getOptions(): array;

    public function getOption(string $option);

    public function hasOption(string $option): bool;

    public function setOption(string $option, $value): void;

    public function getFilter(): string;

    public function setFilter(string $filter): void;
}
