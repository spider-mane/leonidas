<?php

namespace Leonidas\Library\System\Schema\User;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;
use Leonidas\Contracts\System\Schema\User\UserConverterInterface;
use Leonidas\Contracts\System\Schema\User\UserEntityManagerInterface;
use Leonidas\Library\System\Schema\Abstracts\NoCommitmentsTrait;
use Leonidas\Library\System\Schema\Abstracts\ThrowsExceptionOnWpErrorTrait;
use WP_User;
use WP_User_Query;

class UserEntityManager implements UserEntityManagerInterface
{
    use NoCommitmentsTrait;
    use ThrowsExceptionOnWpErrorTrait;

    protected string $role;

    protected UserConverterInterface $entityConverter;

    protected EntityCollectionFactoryInterface $collectionFactory;

    public function __construct(
        string $role,
        UserConverterInterface $userConverter,
        EntityCollectionFactoryInterface $collectionFactory
    ) {
        $this->role = $role;
        $this->entityConverter = $userConverter;
        $this->collectionFactory = $collectionFactory;
    }

    public function select(int $id): ?object
    {
        return $this->single(['include' => [$id]]);
    }

    public function selectLogin(string $login): ?object
    {
        return $this->single(['login' => $login]);
    }

    public function selectEmail(string $email): ?object
    {
        return $this->single(['search_columns' => ['user_email' => $email]]);
    }

    public function selectNicename(string $nicename): ?object
    {
        return $this->single(['nicename' => $nicename]);
    }

    public function whereIds(int ...$ids): object
    {
        return $this->query(['include' => $ids]);
    }

    public function whereBlogId(int $blogId): object
    {
        return $this->query(['blog_id' => $blogId]);
    }

    public function all(): object
    {
        return $this->query([]);
    }

    /**
     * @link https://developer.wordpress.org/reference/classes/WP_User_Query/prepare_query/
     */
    public function query(array $args): object
    {
        return $this->getCollectionFromQuery($this->getQuery($args));
    }

    public function single(array $args): ?object
    {
        $user = $this->getQuery($args)->get_results();

        return $user ? $this->convertEntity($user[0]) : null;
    }

    public function spawn(array $data): object
    {
        return $this->convertEntity(new WP_User());
    }

    /**
     * @link https://developer.wordpress.org/reference/functions/wp_insert_user/
     */
    public function insert(array $data): void
    {
        $this->throwExceptionIfWpError(
            wp_insert_user($this->normalizeDataForEntry($data))
        );
    }

    public function update(int $id, array $data): void
    {
        $this->throwExceptionIfWpError(
            wp_update_user($this->normalizeDataForEntry($data, $id))
        );
    }

    public function delete(int $id, ?int $reassign = null): void
    {
        wp_delete_user($id, $reassign);
    }

    protected function getQuery(array $args): WP_User_Query
    {
        return new WP_User_Query($this->normalizeQueryArgs($args));
    }

    protected function getCollectionFromQuery(WP_User_Query $query): object
    {
        return $this->createCollection(...$query->get_results());
    }

    protected function normalizeQueryArgs(array $args): array
    {
        return [
            // 'role' => $this->role,
            'fields' => 'all',
        ] + $args;
    }

    protected function normalizeDataForEntry(array $data, int $id = 0)
    {
        return [
            'ID' => $id,
            'role' => $this->role,
        ] + $data;
    }

    protected function resolveFound($result): ?object
    {
        return $result instanceof WP_User ? $this->convertEntity($result) : null;
    }

    protected function convertEntity(WP_User $user): object
    {
        return $this->entityConverter->convert($user);
    }

    public function createCollection(WP_User ...$users): object
    {
        return $this->collectionFactory->createEntityCollection(
            ...array_map([$this, 'convertEntity'], $users)
        );
    }
}
