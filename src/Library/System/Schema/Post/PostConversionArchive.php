<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\Post\PostConversionArchiveInterface;
use Leonidas\Library\System\Schema\AbstractEntityConversionArchive;
use WP_Post;

class PostConversionArchive extends AbstractEntityConversionArchive implements PostConversionArchiveInterface
{
    public function getConversion(WP_Post $post): object
    {
        return $this->conversions[$this->hash($post)];
    }

    public function getReversion($entity): WP_Post
    {
        return $this->reversions[$this->hash($entity)];
    }

    public function archive(WP_Post $post, object $entity): void
    {
        $this->reversions[$this->hash($entity)] = $post;
        $this->conversions[$this->hash($post)] = $entity;
    }
}
