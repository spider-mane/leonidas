<?php

namespace Leonidas\Library\System\Model\Image\Abstracts;

use Leonidas\Contracts\System\Model\Image\ImageCollectionInterface;
use Leonidas\Contracts\System\Model\Image\ImageInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;

abstract class AbstractImageCollection extends AbstractModelCollection implements ImageCollectionInterface
{
    public function getById(int $id): ?ImageInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
    }

    public function getByName(string $name): ?ImageInterface
    {
        return $this->kernel->firstWhere('name', '=', $name);
    }

    public function hasWithId(int $id): bool
    {
        return $this->kernel->hasWhere('id', '=', $id);
    }

    public function hasWithName(string $name): bool
    {
        return $this->kernel->hasWhere('name', '=', $name);
    }

    public function hasWithSrc(string $src): bool
    {
        return $this->kernel->hasWhere('src', '=', $src);
    }

    public function getBySrc(string $src): ?ImageInterface
    {
        return $this->kernel->firstWhere('src', '=', $src);
    }

    public function add(ImageInterface $image): void
    {
        $this->kernel->insert($image);
    }

    public function collect(ImageInterface ...$images): void
    {
        $this->kernel->collect($images);
    }

    public function sortBy(string $property, string $order = 'ASC'): ImageCollectionInterface
    {
        return $this->kernel->sortBy($property, $order);
    }

    public function sortMappedById(array $map, string $order = 'ASC'): self
    {
        return $this->kernel->sortMapped($map, 'id', $order);
    }

    public function sortMappedByName(array $map, string $order = 'ASC'): self
    {
        return $this->kernel->sortMapped($map, 'name', $order);
    }
}
