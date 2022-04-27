<?php

namespace Leonidas\Contracts\System\Model\Attachment;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\DatableInterface;
use Leonidas\Contracts\System\Model\EntityModelInterface;
use Psr\Link\LinkInterface;

interface AttachmentInterface extends EntityModelInterface, DatableInterface
{
    public function getName(): string;

    public function getTitle(): string;

    public function getCaption(): string;

    public function getDescription(): string;

    public function getAuthor(): AuthorInterface;

    public function getPassword(): ?string;

    public function getGuid(): LinkInterface;

    public function getMenuOrder(): int;

    public function getMimeType(): string;

    public function getCommentCount(): int;

    public function getFilter(): string;

    public function applyFilter(string $filter);

    public function pageTemplate(): string;

    public function setName(string $name): AttachmentInterface;

    public function setTitle(string $title): AttachmentInterface;

    public function setCaption(string $caption): AttachmentInterface;

    public function setDescription(string $description): AttachmentInterface;

    public function setAuthor(AuthorInterface $author): AttachmentInterface;

    public function setPassword(string $password): ?AttachmentInterface;

    public function setGuid(LinkInterface $name): AttachmentInterface;

    public function setMenuOrder(int $menuOrder): AttachmentInterface;

    public function setMimeType(string $mimeType): AttachmentInterface;

    public function setCommentCount(int $commentCount): AttachmentInterface;

    public function setFilter(string $filter): AttachmentInterface;
}
