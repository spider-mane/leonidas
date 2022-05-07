<?php

namespace Leonidas\Contracts\System\Model\Image;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface ImageCollectionInterface extends ModelCollectionInterface
{
    public function getById(int $id): ?ImageInterface;

    public function getByName(string $name): ?ImageInterface;

    public function getBySrc(string $src): ?ImageInterface;

    public function hasWithId(int $id): bool;

    public function hasWithName(string $name): bool;

    public function hasWithSrc(string $src): bool;

    public function add(ImageInterface $image): void;

    public function collect(ImageInterface ...$images): void;

    public function sortBy(string $property, string $order = 'ASC'): ImageCollectionInterface;

    public function sortMappedById(array $map, string $order = 'ASC'): ImageCollectionInterface;

    public function sortMappedByName(array $map, string $order = 'ASC'): ImageCollectionInterface;
}
