<?php

namespace Leonidas\Library\System\Model\Author;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Library\System\Model\Post\PostCollection;
use Leonidas\Library\System\Model\User\User;

class Author extends User implements AuthorInterface
{
    public function getPosts(): PostCollectionInterface
    {
        return PostCollection::fromLegacy(...get_posts(
            [
                'author' => $this->user->ID,
                'post_status' => 'publish',
                'posts_per_page' => -1,
            ]
        ));
    }

    public function getDrafts(): PostCollectionInterface
    {
        return PostCollection::fromLegacy(...get_posts(
            [
                'author' => $this->user->ID,
                'post_status' => 'draft',
                'posts_per_page' => -1,
            ]
        ));
    }
}
