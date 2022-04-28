<?php

namespace Leonidas\Library\System\Schema\Comment;

use Leonidas\Contracts\System\Schema\Comment\CommentConverterInterface;
use Leonidas\Contracts\System\Schema\Comment\CommentEntityManagerInterface;
use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;
use Leonidas\Library\System\Schema\Abstracts\NoCommitmentsTrait;
use Leonidas\Library\System\Schema\Abstracts\ThrowsExceptionOnErrorTrait;
use WP_Comment;
use WP_Comment_Query;

class CommentEntityManager implements CommentEntityManagerInterface
{
    use NoCommitmentsTrait;
    use ThrowsExceptionOnErrorTrait;

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
        return $this->find(['comment_in' => $ids]);
    }

    public function whereAuthorIds(int ...$authorIds): object
    {
        return $this->find(['author__in' => $authorIds]);
    }

    public function whereAuthorEmail(string $authorEmail): object
    {
        return $this->find(['author_email' => $authorEmail]);
    }

    public function whereAuthorUrl(string $authorUrl): object
    {
        return $this->find(['author_url' => $authorUrl]);
    }

    public function whereParentIds(int ...$parentId): object
    {
        return $this->find(['parent__in' => $parentId]);
    }

    public function all(): object
    {
        return $this->find([]);
    }

    public function find(array $queryArgs): object
    {
        return $this->query(new WP_Comment_Query($queryArgs));
    }

    public function query(WP_Comment_Query $query): object
    {
        $query->query_vars['type'] = $this->type;

        return $this->createCollection(...$query->get_comments());
    }

    public function insert(array $data): void
    {
        wp_insert_comment($this->normalizeDataForEntry($data));
    }

    public function update(int $id, array $data): void
    {
        $this->throwExceptionIfError(
            wp_update_comment($this->normalizeDataForEntry($data))
        );
    }

    public function delete(int $id): void
    {
        wp_delete_comment($id);
    }

    protected function normalizeDataForEntry(array $data, int $id = 0)
    {
        return [
            'comment_ID' => $id,
            'role' => $this->role,
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
