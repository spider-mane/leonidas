<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Post\PostEntityManagerInterface;
use Leonidas\Library\System\Schema\Abstracts\NoCommitmentsTrait;
use Leonidas\Library\System\Schema\Abstracts\ThrowsExceptionOnErrorTrait;
use WP_Post;
use WP_Query;

class PostEntityManager implements PostEntityManagerInterface
{
    use NoCommitmentsTrait;
    use ThrowsExceptionOnErrorTrait;

    protected string $type;

    protected PostConverterInterface $entityConverter;

    protected EntityCollectionFactoryInterface $collectionFactory;

    public function __construct(
        string $type,
        PostConverterInterface $postConverter,
        EntityCollectionFactoryInterface $collectionFactory
    ) {
        $this->type = $type;
        $this->entityConverter = $postConverter;
        $this->collectionFactory = $collectionFactory;
    }

    public function select(int $id): object
    {
        return $this->convertEntity(get_post($id, OBJECT));
    }

    public function whereIds(int ...$ids): object
    {
        return $this->find([
            'post__in' => $ids,
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ]);
    }

    public function selectByName(string $name): object
    {
        return $this->convertEntity(
            get_page_by_path($name, OBJECT, $this->type)
        );
    }

    public function whereNames(string ...$names): object
    {
        return $this->find([
            'post_name__in' => $names,
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ]);
    }

    public function whereUser(int $user): object
    {
        return $this->find([
            'author' => $user,
            'post_status' => 'any',
            'posts_per_page' => -1,
        ]);
    }

    public function whereUserAndStatus(int $user, string $status): object
    {
        return $this->find([
            'author' => $user,
            'post_status' => $status,
            'posts_per_page' => -1,
        ]);
    }

    public function whereParentId(int $parentId): object
    {
        return $this->find([
            'post_parent' => $parentId,
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ]);
    }

    public function whereStatus(string $status): object
    {
        return $this->find([
            'post_status' => $status,
            'posts_per_page' => -1,
        ]);
    }

    public function all(): object
    {
        return $this->find([
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ]);
    }

    public function find(array $queryArgs): object
    {
        return $this->query(new WP_Query($queryArgs));
    }

    public function query(WP_Query $query): object
    {
        $query->set('post_type', $this->type);

        return $this->createCollection(...$query->get_posts());
    }

    public function insert(array $data): void
    {
        $this->throwExceptionIfError(
            wp_insert_post($this->normalizeDataForEntry($data))
        );
    }

    public function update(int $id, array $data): void
    {
        $this->throwExceptionIfError(
            wp_update_post($this->normalizeDataForEntry($data, $id))
        );
    }

    public function delete(int $id): void
    {
        wp_delete_post($id, true);
    }

    public function trash(int $id): void
    {
        wp_trash_post($id);
    }

    public function recover(int $id): void
    {
        wp_untrash_post($id);
    }

    protected function normalizeDataForEntry(array $data, int $id = 0): array
    {
        return [
            'id' => $id,
            'post_type' => $this->type,
            'post_parent' => is_post_type_hierarchical($this->type)
                ? $data['post_parent']
                : 0,
        ] + $data;
    }

    protected function convertEntity(WP_Post $post): object
    {
        return $this->entityConverter->convert($post);
    }

    protected function createCollection(WP_Post ...$posts): object
    {
        return $this->collectionFactory->createEntityCollection(
            ...array_map([$this, 'convertEntity'], $posts)
        );
    }
}
