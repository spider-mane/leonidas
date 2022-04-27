<?php

namespace Leonidas\Contracts\System\Schema\Comment;

use Leonidas\Contracts\System\Schema\EntityConversionArchiveInterface;
use WP_Comment;

interface CommentConversionArchiveInterface extends EntityConversionArchiveInterface
{
    public function getConversion(WP_Comment $post): object;

    public function getReversion(object $entity): WP_Comment;

    public function archive(WP_Comment $native, object $conversion): void;
}
