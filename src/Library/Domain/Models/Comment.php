<?php

namespace Leonidas\Library\Domain\Models;

use DateTimeInterface;
use Leonidas\Library\Domain\Interfaces\CommentInterface;

class Comment implements CommentInterface
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $authorName;

    /**
     * @var string
     */
    protected $authorEmail;

    /**
     * @var string
     */
    protected $authorUrl;

    /**
     * @var string
     */
    protected $authorIp;

    /**
     * @var DateTimeInterface
     */
    protected $dateCreated;

    /**
     * @var int
     */
    protected $karma;

    /**
     * @var bool
     */
    protected $isApproved;

    /**
     * @var Comment
     */
    protected $parent;
}
