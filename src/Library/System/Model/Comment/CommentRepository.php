<?php

namespace Leonidas\Library\System\Model\Comment;

use Leonidas\Contracts\System\Model\Comment\CommentCollectionInterface;
use Leonidas\Contracts\System\Model\Comment\CommentInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\PostModelInterface;
use Leonidas\Contracts\System\Schema\Comment\CommentEntityManagerInterface;
use Leonidas\Library\System\Model\Abstracts\HierarchicalModelRepositoryTrait;
use Leonidas\Library\System\Schema\Comment\CommentEntityManager;

class CommentRepository implements CommentRepositoryInterface
{
    use HierarchicalModelRepositoryTrait;

    protected CommentEntityManagerInterface $manager;

    public function __construct(CommentEntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function select(int $id): ?CommentInterface
    {
        return $this->manager->select($id);
    }

    public function whereApprovedOnPost(PostModelInterface $post): CommentCollectionInterface
    {
        return $this->manager->whereApprovedOnPost($post->getId());
    }

    public function whereIds(int ...$ids): CommentCollectionInterface
    {
        return $this->manager->whereIds(...$ids);
    }

    public function whereParent(CommentInterface $comment): CommentCollectionInterface
    {
        return $this->manager->whereParentIds($comment->getId());
    }

    public function whereChild(CommentInterface $comment): ?CommentInterface
    {
        return $this->manager->select($comment->getParentId());
    }

    public function all(): CommentCollectionInterface
    {
        return $this->manager->all();
    }

    public function insert(CommentInterface $comment): void
    {
        $this->manager->insert($this->extractData($comment));
    }

    public function update(CommentInterface $comment): void
    {
        $this->manager->update($comment->getId(), $this->extractData($comment));
    }

    public function delete(int $id): void
    {
        $this->manager->delete($id);
    }

    public function extractData(CommentInterface $comment): array
    {
        $dateFormat = CommentEntityManagerInterface::DATE_FORMAT;

        return [
            'comment_post_ID' => $comment->getPostId(),
            'comment_author' => $comment->getAuthor(),
            'comment_author_email' => $comment->getAuthorEmail(),
            'comment_author_url' => $comment->getAuthorUrl(),
            'comment_author_IP' => $comment->getAuthorIp(),
            'comment_date' => $comment->getDate()->format($dateFormat),
            'comment_date_gmt' => $comment->getDateGmt()->format($dateFormat),
            'comment_content' => $comment->getContent(),
            'comment_karma' => $comment->getKarma(),
            'comment_approved' => $comment->getApprovalStatus(),
            'comment_agent' => $comment->getAuthorUserAgent(),
            'comment_type' => $comment->getType(),
            'comment_parent' => $comment->getParentId(),
            'user_id' => $this->resolveUserId($comment),
            'comment_meta' => $this->extractMetadata($comment),
        ];
    }

    protected function resolveUserId(CommentInterface $comment): int
    {
        return ($user = $comment->getUser()) ? $user->getId() : 0;
    }

    protected function extractMetadata(CommentInterface $comment): array
    {
        return [];
    }
}
