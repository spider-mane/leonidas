<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use Leonidas\Contracts\System\Model\Category\CategoryRepositoryInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Tag\TagRepositoryInterface;
use Leonidas\Library\System\Model\Abstracts\Post\FilterablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MimePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableAuthoredPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableCommentablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableContentPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableDatablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutablePingablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\PolymorphicPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\RestrictablePostModelTrait;
use Leonidas\Library\System\Model\Post\Abstracts\MutablePostTrait;
use Leonidas\Library\System\Schema\Post\Traits\ValidatesPostTypeTrait;
use ReturnTypeWillChange;
use WP_Post;

class Post implements PostInterface
{
    use FilterablePostModelTrait;
    use MimePostModelTrait;
    use MutableAuthoredPostModelTrait;
    use MutableCommentablePostModelTrait;
    use MutableContentPostModelTrait;
    use MutableDatablePostModelTrait;
    use MutablePingablePostModelTrait;
    use MutablePostModelTrait;
    use MutablePostTrait;
    use PolymorphicPostModelTrait;
    use RestrictablePostModelTrait;
    use ValidatesPostTypeTrait;

    protected WP_Post $post;

    protected GetAccessProviderInterface $getAccessProvider;

    protected SetAccessProviderInterface $setAccessProvider;

    public function __construct(
        WP_Post $post,
        AuthorRepositoryInterface $authorRepository,
        TagRepositoryInterface $tagRepository,
        CategoryRepositoryInterface $categoryRepository,
        CommentRepositoryInterface $commentRepository,
        ?GetAccessProviderInterface $getAccessProvider = null,
        ?SetAccessProviderInterface $setAccessProvider = null,
        string $postTypePrefix = ''
    ) {
        $this->validatePostType($post, $postTypePrefix . 'post');

        $this->post = $post;
        $this->authorRepository = $authorRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
        $this->commentRepository = $commentRepository;

        $this->getAccessProvider = $getAccessProvider
            ?? new PostGetAccessProvider($this);

        $this->setAccessProvider = $setAccessProvider
            ?? new PostSetAccessProvider($this);
    }

    #[ReturnTypeWillChange]
    public function __get($name)
    {
        $this->getAccessProvider->get($name);
    }

    public function __set($name, $value): void
    {
        $this->setAccessProvider->set($name, $value);
    }

    public function __isset($name)
    {
        return $this->post->__isset($name);
    }

    public function __toString(): string
    {
        return $this->getContent();
    }
}
