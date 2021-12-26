<?php

namespace Leonidas\Library\Domain\Interfaces;

use Carbon\CarbonInterface;
use Psr\Link\LinkInterface;

interface PostDataProviderInterface
{
    public function getId(): int;

    public function getAuthor(): UserInterface;

    public function getDate(): CarbonInterface;

    public function getDateGmt(): CarbonInterface;

    public function getContent(): DynamicTextInterface;

    public function getTitle(): string;

    public function getExcerpt(): string;

    public function getStatus(): PostStatusInterface;

    public function getPingStatus(): string;

    public function getPassword(): ?string;

    public function getName(): string;

    public function toPing(): string;

    public function hasBeenPinged(): bool;

    public function getDateModified(): CarbonInterface;

    public function getContentFiltered(): string;

    public function getParentId(): int;

    public function getParent(): ?PostDataProviderInterface;

    public function getGuid(): LinkInterface;

    public function getMenuOrder(): int;

    public function getPostType(): PostTypeInterface;

    public function getMimeType(): string;

    public function getCommentCount(): int;

    public function getFilter(): string;
}
