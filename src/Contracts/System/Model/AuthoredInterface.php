<?php

namespace Leonidas\Contracts\System\Model;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;

interface AuthoredInterface
{
    public function getAuthor(): AuthorInterface;
}
