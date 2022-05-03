<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

trait MutableCommentablePostModelTrait
{
    use CommentablePostModelTrait;

    public function setCommentStatus(string $commentStatus): self
    {
        $this->post->comment_status = $commentStatus;

        return $this;
    }

    public function setCommentCount(int $commentCount): self
    {
        $this->post->comment_count = (string) $commentCount;

        return $this;
    }
}
