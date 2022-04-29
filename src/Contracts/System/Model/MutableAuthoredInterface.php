<?php

namespace Leonidas\Contracts\System\Model;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;

interface MutableAuthoredInterface extends AuthoredInterface
{
    public function setAuthor(AuthorInterface $author): self;
}
