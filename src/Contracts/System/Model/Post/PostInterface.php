<?php

namespace Leonidas\Contracts\System\Model\Post;

use DateTimeInterface;
use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\PostType\PostTypeInterface;
use Leonidas\Contracts\System\Model\Tag\TagCollectionInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Psr\Link\LinkInterface;

interface PostInterface
{
    public function getId(): int;

    public function getName(): string;

    public function getAuthor(): UserInterface;

    public function getContent(): string;

    public function getTitle(): string;

    public function getExcerpt(): string;

    public function getStatus(): PostStatusInterface;

    public function getDate(): DateTimeInterface;

    public function getDateGmt(): DateTimeInterface;

    public function getDateModified(): DateTimeInterface;

    public function getDateModifiedGmt(): DateTimeInterface;

    public function getPingStatus(): string;

    public function getPassword(): ?string;

    public function toPing(): string;

    public function hasBeenPinged(): bool;

    public function getContentFiltered(): string;

    public function getParentId(): int;

    public function getParent(): ?PostInterface;

    public function getGuid(): LinkInterface;

    public function getMenuOrder(): int;

    public function getPostType(): PostTypeInterface;

    public function getMimeType(): string;

    public function getCommentCount(): int;

    public function getFilter(): string;

    public function pageTemplate(): string;

    public function getCategories(): CategoryCollectionInterface;

    public function getTags(): TagCollectionInterface;
}
