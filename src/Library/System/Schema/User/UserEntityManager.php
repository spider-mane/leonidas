<?php

namespace Leonidas\Library\System\Schema\User;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;
use Leonidas\Contracts\System\Schema\User\UserConverterInterface;
use Leonidas\Contracts\System\Schema\User\UserEntityManagerInterface;
use Leonidas\Library\System\Schema\Abstracts\NoCommitmentsTrait;
use Leonidas\Library\System\Schema\Abstracts\ThrowsExceptionOnErrorTrait;
use WP_User;
use WP_User_Query;

class UserEntityManager implements UserEntityManagerInterface
{
    use NoCommitmentsTrait;
    use ThrowsExceptionOnErrorTrait;

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

    public function select(int $id): object
    {
        return $this->convertEntity(get_user_by('ID', $id));
    }

    public function whereIds(int ...$ids): object
    {
        return $this->query(['include' => $ids]);
    }

    public function selectByLogin(string $login): object
    {
        return $this->convertEntity(get_user_by('login', $login));
    }

    public function selectByEmail(string $email): object
    {
        return $this->convertEntity(get_user_by('email', $email));
    }

    public function selectByNicename(string $nicename): object
    {
        return $this->convertEntity(get_user_by('nicename', $nicename));
    }

    public function whereBlogId(int $blogId): object
    {
        return $this->query(['blog_id' => $blogId]);
    }

    public function all(): object
    {
        return $this->query([]);
    }

    public function query(array $args): object
    {
        return $this->getCollectionFromQuery(
            new WP_User_Query($this->normalizeQueryArgs($args))
        );
    }

    public function insert(array $data): void
    {
        $this->throwExceptionIfError(
            wp_insert_user($this->normalizeDataForEntry($data))
        );
    }

    public function update(int $id, array $data): void
    {
        $this->throwExceptionIfError(
            wp_update_user($this->normalizeDataForEntry($data, $id))
        );
    }

    public function delete(int $id, ?int $reassign = null): void
    {
        wp_delete_user($id, $reassign);
    }

    protected function getCollectionFromQuery(WP_User_Query $query): object
    {
        return $this->createCollection(...$query->get_results());
    }

    protected function normalizeQueryArgs(array $args): array
    {
        return [
            'role' => $this->role,
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
