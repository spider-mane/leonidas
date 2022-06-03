<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\Comment\CommentCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\Tag\TagCollectionInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
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
        AutoInvokerInterface $autoInvoker,
        ?AuthorInterface $author = null,
        ?TagCollectionInterface $tags = null,
        ?CategoryCollectionInterface $categories = null,
        ?CommentCollectionInterface $comments = null
    ) {
        $this->assertPostType($post, 'post');

        $this->post = $post;
        $this->autoInvoker = $autoInvoker;

        $author && $this->author = $author;
        $tags && $this->tags = $tags;
        $categories && $this->categories = $categories;
        $comments && $this->comments = $comments;

        $this->getAccessProvider = new PostTemplateTags($this, $post);
        $this->setAccessProvider = new PostSetAccessProvider($this);
    }

    public function __toString(): string
    {
        return $this->getContent();
    }
}
