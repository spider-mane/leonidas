<?php

namespace Leonidas\Contracts\System\Model\Comment;

use DateTimeInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;

interface CommentInterface
{
    public function getId(): int;

    public function getAuthor(): UserInterface;

    public function getContent(): string;

    public function getDate(): DateTimeInterface;

    public function getDateGmt(): DateTimeInterface;

    public function getKarma(): int;

    public function getParent(): ?CommentInterface;

    public function getParentId(): int;

    public function getChildren(): CommentCollectionInterface;

    public function getPost(): PostInterface;

    public function getPostId(): int;

    public function getStatus(): string;

    public function getType(): string;
}
