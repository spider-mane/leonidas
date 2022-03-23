<?php

namespace Leonidas\Contracts\System\Model\Attachment;

use DateTimeInterface;
use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\Tag\TagCollectionInterface;
use Psr\Link\LinkInterface;

interface AttachmentInterface
{
    public function getId(): int;

    public function getName(): string;

    public function getTitle(): string;

    public function getCaption(): string;

    public function getDescription(): string;

    public function getAuthor(): AuthorInterface;

    public function getDateCreated(): DateTimeInterface;

    public function getDateCreatedGmt(): DateTimeInterface;

    public function getDateModified(): DateTimeInterface;

    public function getDateModifiedGmt(): DateTimeInterface;

    public function getPassword(): ?string;

    public function getGuid(): LinkInterface;

    public function getMenuOrder(): int;

    public function getMimeType(): string;

    public function getCommentCount(): int;

    public function getFilter(): string;

    public function applyFilter(string $filter);

    public function pageTemplate(): string;
}
