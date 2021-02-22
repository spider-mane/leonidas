<?php

namespace WebTheory\Leonidas\Core\Util;

abstract class AbstractWpObjectCollection
{
    /**
     *
     */
    protected const ID_KEY = '';

    /**
     *
     */
    protected const NAME_KEY = '';

    /**
     *
     */
    protected const SLUG_KEY = '';

    /**
     *
     */
    protected const OBJECT_TYPE = '';

    /**
     *
     */
    protected const COLLECTION = '';

    /**
     *
     */
    public function getCollection(): array
    {
        return $this->{static::COLLECTION};
    }

    /**
     *
     */
    public function get(string $property): array
    {
        return array_map(function ($object) use ($property) {
            return $object->{$property};
        }, $this->{static::COLLECTION});
    }

    /**
     *
     */
    public function getIds(): array
    {
        return $this->get(static::ID_KEY);
    }

    /**
     *
     */
    public function getNames(): array
    {
        return $this->get(static::NAME_KEY);
    }

    /**
     *
     */
    public function getSlugs(): array
    {
        return $this->get(static::SLUG_KEY);
    }

    /**
     *
     */
    public function getMeta(string $metaKey): array
    {
        $meta = [];

        foreach ($this->{static::COLLECTION} as $object) {
            $id = $object->{static::ID_KEY};

            $meta[$id] = $this->getObjectMetadata($object, $metaKey);
        }

        return $meta;
    }

    /**
     *
     */
    public function isEmpty(): bool
    {
        return empty($this->{static::COLLECTION});
    }

    /**
     *
     */
    public function sortByMeta(string $metaKey)
    {
        $orderArray = [];

        $collection = $this->{static::COLLECTION};
        $id = static::ID_KEY;

        foreach ($collection as $item) {
            $orderArray[$item->{$id}] = $this->getObjectMetadata($item, $metaKey);
        }

        usort($collection, $this->sortByMetaCallback($orderArray));

        return $collection;
    }

    /**
     *
     */
    public function without(AbstractWpObjectCollection $collection)
    {
        return array_udiff(
            $this->getCollection(),
            $collection->getCollection(),
            $this->diffCallback()
        );
    }

    /**
     *
     */
    protected function getObjectMetadata(object $object, string $metaKey)
    {
        return get_metadata(static::OBJECT_TYPE, $object->{static::ID_KEY}, $metaKey, true);
    }

    /**
     *
     */
    protected function diffCallback()
    {
        return function ($object1, $object2) {
            return $object1->{static::ID_KEY} - $object2->{static::ID_KEY};
        };
    }

    /**
     * @param array $objectsArray
     * @param array $orderArray
     * @param string $orderKey
     * @return array
     */
    protected function sortByMetaCallback(array $orderArray): callable
    {
        return function ($a, $b) use ($orderArray) {

            foreach ([&$a, &$b] as &$obj) {
                $id = $obj->{static::ID_KEY};

                //! Explain this sh*t!
                $obj = (int) $orderArray[$id] >= 0 ? $orderArray[$id] : 0;
            }

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
