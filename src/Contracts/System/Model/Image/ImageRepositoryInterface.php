<?php

namespace Leonidas\Contracts\System\Model\Image;

use Leonidas\Contracts\System\Model\SoftDeletingRepositoryInterface;
use WP_Query;

interface ImageRepositoryInterface extends SoftDeletingRepositoryInterface
{
    public function select(int $id): ImageInterface;

    public function whereIds(int ...$ids): ImageCollectionInterface;

    public function find(array $queryArgs): ImageCollectionInterface;

    public function query(WP_Query $query): ImageCollectionInterface;

    public function all(): ImageCollectionInterface;

    public function insert(ImageInterface $image): void;

    public function update(ImageInterface $image): void;
}
