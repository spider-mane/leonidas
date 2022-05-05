<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Post\PostEntityManagerInterface;
use Leonidas\Library\System\Schema\Abstracts\NoCommitmentsTrait;
use Leonidas\Library\System\Schema\Abstracts\ThrowsExceptionOnWpErrorTrait;
use WP_Post;
use WP_Query;

class PostEntityManager implements PostEntityManagerInterface
{
    use NoCommitmentsTrait;
    use ThrowsExceptionOnWpErrorTrait;

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
        return $this->query(['post__in' => $ids]);
    }

    public function selectByName(string $name): object
    {
        return $this->convertEntity(
            get_page_by_path($name, OBJECT, $this->type)
        );
    }

    public function whereNames(string ...$names): object
    {
        return $this->query(['post_name__in' => $names]);
    }

    public function whereUser(int $user): object
    {
        return $this->query(['author' => $user, 'post_status' => 'any']);
    }

    public function whereUserAndStatus(int $user, string $status): object
    {
        return $this->query(['author' => $user, 'post_status' => $status]);
    }

    public function whereParentId(int $parentId): object
    {
        return $this->query(['post_parent' => $parentId]);
    }

    public function whereStatus(string $status): object
    {
        return $this->query(['post_status' => $status]);
    }

    /**
     * @link https://developer.wordpress.org/reference/classes/wp_tax_query/__construct/
     */
    public function whereTaxQuery(array $args): object
    {
        return $this->query(['tax_query' => $args]);
    }

    public function withTerm(string $taxonomy, int $termId): object
    {
        return $this->query([
            'tax_query' => [
                [
                    'field' => 'term_id',
                    'taxonomy' => $taxonomy,
                    'terms' => $termId,
                ],
            ],
        ]);
    }

    public function all(): object
    {
        return $this->query([]);
    }

    public function spawn(array $data): object
    {
        return $this->convertEntity(new WP_Post((object) $data));
    }

    /**
     * @link https://developer.wordpress.org/reference/classes/WP_Query/parse_query/
     */
    public function query(array $args): object
    {
        return $this->getCollectionFromQuery(
            new WP_Query($this->normalizeQueryArgs($args))
        );
    }

    /**
     * @link https://developer.wordpress.org/reference/functions/wp_insert_post/
     */
    public function insert(array $data): void
    {
        $this->throwExceptionIfWpError(
            wp_insert_post($this->normalizeDataForEntry($data))
        );
    }

    public function update(int $id, array $data): void
    {
        $this->throwExceptionIfWpError(
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

    public function getCollectionFromQuery(WP_Query $query): object
    {
        return $this->createCollection(...$query->get_posts());
    }

    protected function normalizeQueryArgs($args): array
    {
        return [
            'post_type' => $this->type,
        ] + $args + [
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ];
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
