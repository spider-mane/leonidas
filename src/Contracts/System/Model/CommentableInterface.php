<?php

namespace Leonidas\Contracts\System\Model;

use Leonidas\Contracts\System\Model\Comment\CommentCollectionInterface;

interface CommentableInterface extends EntityModelInterface
{
    public function getCommentStatus(): string;

    public function getCommentCount(): int;

    public function setCommentStatus(string $commentStatus): self;

    public function setCommentCount(int $commentCount): self;

    public function getComments(): CommentCollectionInterface;
}
