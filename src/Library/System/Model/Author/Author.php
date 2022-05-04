<?php

namespace Leonidas\Library\System\Model\Author;

use Leonidas\Contracts\System\Model\Author\MutableAuthorInterface;
use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostRepositoryInterface;
use Leonidas\Library\System\Model\Abstracts\AllAccessGrantedTrait;
use Leonidas\Library\System\Model\Abstracts\User\MutableUserModelTrait;
use Leonidas\Library\System\Model\Abstracts\User\ValidatesRoleTrait;
use WP_User;

class Author implements MutableAuthorInterface
{
    use AllAccessGrantedTrait;
    use MutableUserModelTrait;
    use ValidatesRoleTrait;

    protected PostCollectionInterface $posts;

    protected PostRepositoryInterface $postRepository;

    public function __construct(WP_User $user, PostRepositoryInterface $postRepository)
    {
        $this->validateRole($user, 'author');

        $this->user = $user;
        $this->postRepository = $postRepository;

        $this->getAccessProvider = new AuthorGetAccessProvider($this);
        $this->setAccessProvider = new AuthorSetAccessProvider($this);
    }

    public function getPosts(): PostCollectionInterface
    {
        return $this->posts ??= $this->getPostsFromRepository();
    }

    public function setPosts(PostCollectionInterface $posts): self
    {
        $this->posts = $posts;

        return $this;
    }

    protected function getPostsFromRepository(): PostCollectionInterface
    {
        return $this->postRepository->whereAuthor($this);
    }
}
