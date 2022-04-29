<?php

namespace Leonidas\Contracts\System\Model\Attachment;

use Leonidas\Contracts\System\Model\CommentableInterface;
use Leonidas\Contracts\System\Model\FilterableInterface;
use Leonidas\Contracts\System\Model\MimeInterface;
use Leonidas\Contracts\System\Model\MutableAuthoredInterface;
use Leonidas\Contracts\System\Model\MutableDatableInterface;
use Leonidas\Contracts\System\Model\MutablePostModelInterface;
use Leonidas\Contracts\System\Model\PingableInterface;
use Leonidas\Contracts\System\Model\RestrictableInterface;

interface AttachmentInterface extends
    MutableAuthoredInterface,
    FilterableInterface,
    MutablePostModelInterface,
    PingableInterface,
    CommentableInterface,
    RestrictableInterface,
    MimeInterface,
    MutableDatableInterface
{
    public function getTitle(): string;

    public function setTitle(string $title): self;

    public function getCaption(): string;

    public function setCaption(string $caption): self;

    public function getDescription(): string;

    public function setDescription(string $description): self;
}
