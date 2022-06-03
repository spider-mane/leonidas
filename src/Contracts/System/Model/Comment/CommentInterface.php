<?php

namespace Leonidas\Contracts\System\Model\Comment;

use DateTimeInterface;
use Leonidas\Contracts\System\Model\HierarchicalInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Stringable;
use WP_Comment;

interface CommentInterface extends HierarchicalInterface, Stringable
{
    public function getId(): int;

    public function getAuthor(): string;

    public function getAuthorEmail(): string;

    public function getAuthorUrl(): string;

    public function getAuthorIp(): string;

    public function getAuthorUserAgent(): string;

    public function getUser(): ?UserInterface;

    public function getUserId(): int;

    public function getContent(): string;

    public function getDate(): DateTimeInterface;

    public function getDateGmt(): DateTimeInterface;

    public function getKarma(): int;

    public function getParent(): ?CommentInterface;

    public function getChildren(): CommentCollectionInterface;

    public function getPost(): PostInterface;

    public function getPostId(): int;

    public function getApprovalStatus(): string;

    public function getType(): string;

    public function getCore(): WP_Comment;
}
