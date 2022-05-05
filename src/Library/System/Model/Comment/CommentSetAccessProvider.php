<?php

namespace Leonidas\Library\System\Model\Comment;

use Leonidas\Contracts\System\Model\Comment\CommentInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Library\System\Model\SetAccessProvider;

class CommentSetAccessProvider extends SetAccessProvider implements SetAccessProviderInterface
{
    public function __construct(CommentInterface $comment)
    {
        parent::__construct($comment, $this->resolvedSetters($comment));
    }

    protected function resolvedSetters(CommentInterface $comment): array
    {
        return [];
    }
}
