<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use Leonidas\Contracts\System\Model\Category\CategoryRepositoryInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\Tag\TagRepositoryInterface;
use Leonidas\Library\System\Model\Abstracts\AllAccessGrantedTrait;
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
use Leonidas\Library\System\Model\Abstracts\Post\ValidatesPostTypeTrait;
use Leonidas\Library\System\Model\Post\Abstracts\MutablePostTrait;
use WP_Post;

class Post implements PostInterface
{
    use AllAccessGrantedTrait;
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

    public function __construct(
        WP_Post $post,
        AuthorRepositoryInterface $authorRepository,
        TagRepositoryInterface $tagRepository,
        CategoryRepositoryInterface $categoryRepository,
        CommentRepositoryInterface $commentRepository
    ) {
        $this->assertPostType($post, 'post');

        $this->post = $post;
        $this->authorRepository = $authorRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
        $this->commentRepository = $commentRepository;

        $this->getAccessProvider = new PostTemplateTags($this, $post);
        $this->setAccessProvider = new PostSetAccessProvider($this);
    }

    public function __toString(): string
    {
        return $this->content; // @phpstan-ignore-line
    }
}
