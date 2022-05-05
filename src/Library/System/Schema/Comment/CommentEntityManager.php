<?php

namespace Leonidas\Library\System\Schema\Comment;

use Leonidas\Contracts\System\Schema\Comment\CommentConverterInterface;
use Leonidas\Contracts\System\Schema\Comment\CommentEntityManagerInterface;
use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;
use Leonidas\Library\System\Schema\Abstracts\NoCommitmentsTrait;
use Leonidas\Library\System\Schema\Abstracts\ThrowsExceptionOnWpErrorTrait;
use WP_Comment;
use WP_Comment_Query;

class CommentEntityManager implements CommentEntityManagerInterface
{
    use NoCommitmentsTrait;
    use ThrowsExceptionOnWpErrorTrait;

    protected string $type;

    protected CommentConverterInterface $entityConverter;

    protected EntityCollectionFactoryInterface $collectionFactory;

    public function __construct(
        string $type,
        CommentConverterInterface $commentConverter,
        EntityCollectionFactoryInterface $collectionFactory
    ) {
        $this->type = $type;
        $this->entityConverter = $commentConverter;
        $this->collectionFactory = $collectionFactory;
    }

    public function select(int $id): object
    {
        return $this->convertEntity(get_comment($id));
    }

    public function whereIds(int ...$ids): object
    {
        return $this->query(['comment_in' => $ids]);
    }

    public function whereUserIds(int ...$userIds): object
    {
        return $this->query(['author__in' => $userIds]);
    }

    public function whereAuthorEmail(string $authorEmail): object
    {
        return $this->query(['author_email' => $authorEmail]);
    }

    public function whereAuthorUrl(string $authorUrl): object
    {
        return $this->query(['author_url' => $authorUrl]);
    }

    public function whereParentIds(int ...$parentId): object
    {
        return $this->query(['parent__in' => $parentId]);
    }

    public function wherePostAndStatus(int $postId, string $status): object
    {
        return $this->query(['post_id' => $postId, 'status' => $status]);
    }

    public function all(): object
    {
        return $this->query([]);
    }

    /**
     * @link https://developer.wordpress.org/reference/classes/WP_Comment_Query/__construct/
     */
    public function query(array $args): object
    {
        return $this->getCollectionFromQuery(
            new WP_Comment_Query($this->normalizeQueryArgs($args))
        );
    }

    public function spawn(array $data): object
    {
        return $this->convertEntity(
            /** @phpstan-ignore-next-line */
            new WP_Comment((object) $data)
        );
    }

    /**
     * @link https://developer.wordpress.org/reference/functions/wp_insert_comment/
     */
    public function insert(array $data): void
    {
        wp_insert_comment($this->normalizeDataForEntry($data));
    }

    public function update(int $id, array $data): void
    {
        $this->throwExceptionIfWpError(
            wp_update_comment($this->normalizeDataForEntry($data, $id))
        );
    }

    public function delete(int $id): void
    {
        wp_delete_comment($id);
    }

    protected function getCollectionFromQuery(WP_Comment_Query $query): object
    {
        return $this->createCollection(...$query->get_comments());
    }

    protected function normalizeQueryArgs(array $args): array
    {
        return [
            'type' => $this->type,
            'fields' => null,
            'hierarchical' => false,
        ] + $args;
    }

    protected function normalizeDataForEntry(array $data, int $id = 0)
    {
        return [
            'comment_ID' => $id,
            'type' => $this->type,
        ] + $data;
    }

    protected function convertEntity(WP_Comment $user): object
    {
        return $this->entityConverter->convert($user);
    }

    public function createCollection(WP_Comment ...$users): object
    {
        return $this->collectionFactory->createEntityCollection(
            ...array_map([$this, 'convertEntity'], $users)
        );
    }
}
