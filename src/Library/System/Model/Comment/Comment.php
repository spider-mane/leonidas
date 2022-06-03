<?php

namespace Leonidas\Library\System\Model\Comment;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Leonidas\Contracts\System\Model\Comment\CommentCollectionInterface;
use Leonidas\Contracts\System\Model\Comment\CommentInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\Post\PostRepositoryInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Contracts\System\Model\User\UserRepositoryInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Model\Abstracts\AllAccessGrantedTrait;
use Leonidas\Library\System\Model\Abstracts\Comment\MappedToWpCommentTrait;
use Leonidas\Library\System\Model\Abstracts\LazyLoadableRelationshipsTrait;
use WP_Comment;

class Comment implements CommentInterface
{
    use AllAccessGrantedTrait;
    use LazyLoadableRelationshipsTrait;
    use MappedToWpCommentTrait;

    protected ?CommentInterface $parent;

    protected CommentCollectionInterface $children;

    protected PostInterface $post;

    protected ?UserInterface $user;

    public function __construct(
        WP_Comment $comment,
        AutoInvokerInterface $autoInvoker,
        ?CommentInterface $parent = null,
        ?CommentCollectionInterface $children = null,
        ?PostInterface $post = null,
        ?UserInterface $user = null
    ) {
        $this->comment = $comment;
        $this->autoInvoker = $autoInvoker;

        $parent && $this->parent = $parent;
        $children && $this->children = $children;
        $post && $this->post = $post;
        $user && $this->user = $user;

        $this->getAccessProvider = new CommentGetAccessProvider($this);
        $this->setAccessProvider = new CommentSetAccessProvider($this);
    }

    public function __toString(): string
    {
        return $this->getContent();
    }

    public function getId(): int
    {
        return (int) $this->comment->comment_ID;
    }

    public function getCore(): WP_Comment
    {
        return $this->comment;
    }

    public function getAuthor(): string
    {
        return $this->comment->comment_author;
    }

    public function getAuthorEmail(): string
    {
        return $this->comment->comment_author_email;
    }

    public function getAuthorUrl(): string
    {
        return $this->comment->comment_author_url;
    }

    public function getAuthorIp(): string
    {
        return $this->comment->comment_author_IP;
    }

    public function getAuthorUserAgent(): string
    {
        return $this->comment->comment_agent;
    }

    public function getUserId(): int
    {
        return (int) $this->comment->user_id;
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
        return (int) $this->comment->comment_karma;
    }

    public function getParentId(): int
    {
        return (int) $this->comment->comment_parent;
    }

    public function getUser(): ?UserInterface
    {
        return $this->lazyLoadableNullable('user', fn (
            UserRepositoryInterface $users
        ) => $users->select($this->getUserId()));
    }

    public function getParent(): ?CommentInterface
    {
        return $this->lazyLoadableNullable('parent', fn (
            CommentRepositoryInterface $comments
        ) => $comments->select($this->getParentId()));
    }

    public function getChildren(): CommentCollectionInterface
    {
        return $this->lazyLoadable('children', fn (
            CommentRepositoryInterface $comments
        ) => $comments->whereParent($this));
    }

    public function getPost(): PostInterface
    {
        return $this->lazyLoadable('post', fn (
            PostRepositoryInterface $posts
        ) => $posts->select($this->getPostId()));
    }

    public function getPostId(): int
    {
        return (int) $this->comment->comment_post_ID;
    }

    public function getApprovalStatus(): string
    {
        return $this->comment->comment_approved;
    }

    public function getType(): string
    {
        return $this->comment->comment_type;
    }
}
