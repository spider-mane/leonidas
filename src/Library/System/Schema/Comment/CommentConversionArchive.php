<?php

namespace Leonidas\Library\System\Schema\Comment;

use Leonidas\Contracts\System\Schema\Comment\CommentConversionArchiveInterface;
use Leonidas\Library\System\Schema\Abstracts\AbstractEntityConversionArchive;
use WP_Comment;

class CommentConversionArchive extends AbstractEntityConversionArchive implements CommentConversionArchiveInterface
{
    protected array $conversions = [];

    protected array $reversions = [];

    public function getConversion(WP_Comment $comment): object
    {
        return $this->conversions[$this->hash($comment)];
    }

    public function getReversion(object $entity): WP_Comment
    {
        return $this->reversions[$this->hash($entity)];
    }

    public function archive(WP_Comment $comment, object $entity): void
    {
        $this->reversions[$this->hash($entity)] = $comment;
        $this->conversions[$this->hash($comment)] = $entity;
    }
}
