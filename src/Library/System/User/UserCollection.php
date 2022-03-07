<?php

namespace Leonidas\Library\System\User;

use Contracts\Collection\CollectionInterface;
use Leonidas\Library\System\SystemModelCollection;
use WP_User;

class UserCollection implements CollectionInterface
{
    protected const ENTITY_TYPE = 'user';

    protected const ID_KEY = 'ID';

    protected const SLUG_KEY = 'user_nicename';

    protected SystemModelCollection $users;

    public function __construct(WP_User ...$users)
    {
        $this->users = new SystemModelCollection(
            static::ENTITY_TYPE,
            static::ID_KEY,
            static::SLUG_KEY,
            $users
        );
    }

    public function select(string $property): array
    {
        return $this->users->select($property);
    }

    public function getIds(): array
    {
        return $this->users->getIds();
    }

    public function getMeta(string $metaKey): array
    {
        return $this->users->getMeta($metaKey);
    }

    public function has(string $item): bool
    {
        return $this->users->has($item);
    }

    public function remove(string $item): void
    {
        $this->users->remove($item);
    }

    public function all(): array
    {
        return $this->users->all();
    }

    public function isEmpty(): bool
    {
        return $this->users->isEmpty();
    }

    public function diff(UserCollection $collection): UserCollection
    {
        return $this->users->diff($collection);
    }

    public function sortByMeta(string $metaKey)
    {
        return $this->users->sortByMeta($metaKey);
    }
}
