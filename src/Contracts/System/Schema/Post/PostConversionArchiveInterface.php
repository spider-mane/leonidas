<?php

namespace Leonidas\Contracts\System\Schema\Post;

use Leonidas\Contracts\System\Schema\EntityConversionArchiveInterface;
use WP_Post;

interface PostConversionArchiveInterface extends EntityConversionArchiveInterface
{
    public function getConversion(WP_Post $post): object;

    public function getReversion(object $entity): WP_Post;

    public function archive(WP_Post $native, object $conversion): void;
}
