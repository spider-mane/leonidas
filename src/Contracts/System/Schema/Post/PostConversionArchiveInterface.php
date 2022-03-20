<?php

namespace Leonidas\Contracts\System\Schema\Post;

use Leonidas\Contracts\System\Schema\BaseEntityConversionArchiveInterface;
use WP_Post;

interface PostConversionArchiveInterface extends BaseEntityConversionArchiveInterface
{
    public function getConversion(WP_Post $post): object;

    public function getReversion($entity): WP_Post;

    public function archive(WP_Post $native, object $conversion): void;
}
