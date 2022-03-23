<?php

namespace Leonidas\Library\System\Model\Comment;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use DateTimeInterface;
use Leonidas\Contracts\System\Model\Comment\CommentCollectionInterface;
use Leonidas\Contracts\System\Model\Comment\CommentInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Library\System\Model\Post\Post;
use Leonidas\Library\System\Model\User\User;
use WP_Comment;

class Comment implements CommentInterface
{
    protected WP_Comment $comment;

    public function __construct(WP_Comment $comment)
    {
        $this->comment = $comment;
    }

    public function getId(): int
    {
        return $this->comment->comment_ID;
    }

    public function getAuthor(): UserInterface
    {
        return new User(get_user_by('id', $this->comment->user_id));
    }

    public function getContent(): string
    {
        return $this->comment->comment_content;
    }

    public function getDate(): CarbonInterface
    {
        return new Carbon($this->comment->comment_date);
    }

    public function getDateGmt(): CarbonInterface
    {
        return new Carbon($this->comment->comment_date_gmt);
    }

    public function getKarma(): int
    {
        return $this->comment->comment_karma;
    }

    public function getParent(): ?CommentInterface
    {
        return get_comment($this->comment->comment_parent);
    }

    public function getParentId(): int
    {
        return $this->comment->comment_parent;
    }

    public function getChildren(): CommentCollectionInterface
    {
        return new CommentCollection();
    }

    public function getPost(): PostInterface
    {
        return new Post(get_post($this->comment->comment_post_ID));
    }

    public function getPostId(): int
    {
        return $this->comment->comment_post_ID;
    }

    public function getStatus(): string
    {
        return $this->comment->comment_approved;
    }

    public function getType(): string
    {
        return $this->comment->comment_type;
    }
}
