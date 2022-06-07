<?php

namespace Leonidas\Contracts\System\Model\Image;

use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\SoftDeletingRepositoryInterface;

interface ImageRepositoryInterface extends SoftDeletingRepositoryInterface
{
    public function select(int $id): ?ImageInterface;

    public function whereIds(int ...$ids): ImageCollectionInterface;

    public function whereAttachedToPost(PostInterface $post): ImageCollectionInterface;

    public function query(array $args): ImageCollectionInterface;

    public function all(): ImageCollectionInterface;

    public function insert(ImageInterface $image): void;

    public function update(ImageInterface $image): void;
}
