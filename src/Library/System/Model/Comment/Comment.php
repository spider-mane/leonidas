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

    protected CommentRepositoryInterface $commentRepository;

    protected PostRepositoryInterface $postRepository;

    protected UserRepositoryInterface $userRepository;

    public function __construct(
        WP_Comment $comment,
        CommentRepositoryInterface $commentRepository,
        PostRepositoryInterface $postRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->comment = $comment;
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;

        $this->getAccessProvider = new CommentGetAccessProvider($this);
        $this->setAccessProvider = new CommentSetAccessProvider($this);
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

    public function getUser(): ?UserInterface
    {
        return $this->lazyLoadableNullable('user');
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

    public function getParent(): ?CommentInterface
    {
        return $this->lazyLoadableNullable('parent');
    }

    public function getParentId(): int
    {
        return (int) $this->comment->comment_parent;
    }

    public function getChildren(): CommentCollectionInterface
    {
        return $this->lazyLoadable('children');
    }

    public function getPost(): PostInterface
    {
        return $this->lazyLoadable('post');
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

    protected function getPostFromRepository(): PostInterface
    {
        return $this->postRepository->select($this->getPostId());
    }

    public function getParentFromRepository(): ?CommentInterface
    {
        return $this->commentRepository->select($this->getParentId());
    }

    protected function getChildrenFromRepository(): CommentCollectionInterface
    {
        return $this->commentRepository->withParent($this);
    }

    protected function getUserFromRepository(): ?UserInterface
    {
        return $this->userRepository->select($this->getUserId());
    }
}
