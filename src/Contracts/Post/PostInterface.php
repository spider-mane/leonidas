<?php

namespace WebTheory\Leonidas\Contracts\Post;

use DateTime;
use DateTimeZone;

interface PostInterface
{
    public function getId(): int;

    public function getAuthor(): string;

    public function getDate(): DateTime;

    public function getDateGmt(): DateTimeZone;

    public function getContent(): string;

    public function getTitle(): string;

    public function getExcerpt(): string;

    public function getStatus(): string;

    public function getPingStatus(): string;

    public function getPassword(): string;

    public function getName(): string;

    public function toPing(): string;

    public function hasBeenPinged(): bool;

    public function lastModified(): DateTime;

    public function getContentFiltered(): string;

    public function getParent(): ?int;

    public function getGuid(): string;

    public function getMenuOrder(): int;

    public function getPostType(): string;

    public function getMimeType(): string;

    public function getCommentCount(): int;

    public function getFilter(): string;
}
