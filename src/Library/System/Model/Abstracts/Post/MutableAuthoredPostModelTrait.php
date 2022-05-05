<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;

trait MutableAuthoredPostModelTrait
{
    use AuthoredPostModelTrait;

    public function setAuthor(AuthorInterface $author): self
    {
        $this->author = $author;
        $this->post->post_author = (string) $author->getId();

        return $this;
    }
}
