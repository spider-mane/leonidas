<?php

namespace Leonidas\Library\System\Model;

use Contracts\Collection\CollectionInterface;

class SystemModelCollection implements CollectionInterface
{
    protected string $entityType;

    protected string $idKey;

    protected string $slugKey;

    protected array $items;

    public function __construct(string $entityType, string $idKey, string $slugKey, ...$items)
    {
        $this->entityType = $entityType;
        $this->idKey = $idKey;
        $this->slugKey = $slugKey;
        $this->items = $items;
    }

    public function all(): array
    {
        return $this->items;
    }

    public function has(string $item): bool
    {
        return isset($this->items[$item]);
    }

    public function remove(string $item): void
    {
        //
    }

    public function select(string $property): array
    {
        return array_map(function ($object) use ($property) {
            return $object->{$property};
        }, $this->items);
    }

    public function getIds(): array
    {
        return $this->select($this->idKey);
    }

    public function getMeta(string $metaKey): array
    {
        $meta = [];

        foreach ($this->items as $object) {
            $id = $object->{$this->idKey};

            $meta[$id] = $this->getObjectMetadata($object, $metaKey);
        }

        return $meta;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function sortByMeta(string $metaKey)
    {
        $orderArray = [];

        $collection = $this->items;
        $id = $this->idKey;

        foreach ($collection as $item) {
            $orderArray[$item->{$id}] = $this->getObjectMetadata($item, $metaKey);
        }

        usort($collection, $this->sortByMetaCallback($orderArray));

        return $collection;
    }

    public function diff(CollectionInterface $collection): CollectionInterface
    {
        $items = array_udiff(
            $this->all(),
            $collection->all(),
            $this->diffCallback()
        );

        return new static(
            $this->idKey,
            $this->nameKey,
            $this->slugKey,
            $this->entityType,
            $items
        );
    }

    protected function getObjectMetadata(object $object, string $metaKey)
    {
        return get_metadata($this->entityType, $object->{$this->idKey}, $metaKey, true);
    }

    protected function diffCallback(): callable
    {
        return function ($object1, $object2) {
            return $object1->{$this->idKey} - $object2->{$this->idKey};
        };
    }

    /**
     * @param array $orderArray Associative array with object ids as keys and
     *              desired order as values
     *
     * @return callable
     */
    protected function sortByMetaCallback(array $orderArray): callable
    {
        return function ($a, $b) use ($orderArray) {
            // Set value to 0 if one is not provided
            $a = (int) $orderArray[$a->{$this->idKey}] ?? 0;
            $b = (int) $orderArray[$b->{$this->idKey}] ?? 0;

            if ($a === $b) {
                return 0;
            }

            if ($a < $b && $a === 0) {
                return 1;
            }

            if ($a > $b && $b === 0) {
                return -1;
            }

            return $a > $b ? 1 : -1;
        };
    }
}
