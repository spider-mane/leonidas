<?php

namespace Leonidas\Library\System\Model\Author;

use Leonidas\Contracts\System\Model\Author\MutableAuthorInterface;
use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostRepositoryInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Model\Abstracts\AllAccessGrantedTrait;
use Leonidas\Library\System\Model\Abstracts\LazyLoadableRelationshipsTrait;
use Leonidas\Library\System\Model\Abstracts\User\MutableUserModelTrait;
use Leonidas\Library\System\Model\Abstracts\User\ValidatesRoleTrait;
use WP_User;

class Author implements MutableAuthorInterface
{
    use AllAccessGrantedTrait;
    use LazyLoadableRelationshipsTrait;
    use MutableUserModelTrait;
    use ValidatesRoleTrait;

    protected PostCollectionInterface $posts;

    public function __construct(
        WP_User $user,
        AutoInvokerInterface $autoInvoker,
        ?PostCollectionInterface $posts = null
    ) {
        // $this->assertRole($user, 'author');

        $this->user = $user;
        $this->autoInvoker = $autoInvoker;

        $posts && $this->posts = $posts;

        $this->getAccessProvider = new AuthorGetAccessProvider($this);
        $this->setAccessProvider = new AuthorSetAccessProvider($this);
    }

    public function getPosts(): PostCollectionInterface
    {
        return $this->lazyLoadable('posts', fn (
            PostRepositoryInterface $posts
        ) => $posts->whereAuthor($this));
    }

    public function setPosts(PostCollectionInterface $posts): self
    {
        $this->posts = $posts;

        return $this;
    }
}
