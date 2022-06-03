<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Comment\CommentCollectionInterface;
use Leonidas\Contracts\System\Model\Page\PageCollectionInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Model\Abstracts\AllAccessGrantedTrait;
use Leonidas\Library\System\Model\Abstracts\Post\FilterablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\HierarchicalPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MimePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableAuthoredPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableCommentablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableContentPostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutableDatablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutablePingablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MutablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\RestrictablePostModelTrait;
use Leonidas\Library\System\Model\Abstracts\Post\ValidatesPostTypeTrait;
use Leonidas\Library\System\Model\Page\Abstracts\MutablePageTrait;
use WP_Post;

class Page implements PageInterface
{
    use AllAccessGrantedTrait;
    use FilterablePostModelTrait;
    use HierarchicalPostModelTrait;
    use MimePostModelTrait;
    use MutableAuthoredPostModelTrait;
    use MutableCommentablePostModelTrait;
    use MutableContentPostModelTrait;
    use MutableDatablePostModelTrait;
    use MutablePageTrait;
    use MutablePingablePostModelTrait;
    use MutablePostModelTrait;
    use RestrictablePostModelTrait;
    use ValidatesPostTypeTrait;

    public function __construct(
        WP_Post $post,
        AutoInvokerInterface $autoInvoker,
        ?PageInterface $parent = null,
        ?PageCollectionInterface $children = null,
        ?AuthorInterface $author = null,
        ?CommentCollectionInterface $comments = null
    ) {
        $this->assertPostType($post, 'page');

        $this->post = $post;
        $this->autoInvoker = $autoInvoker;

        $parent && $this->parent = $parent;
        $children && $this->children = $children;
        $author && $this->author = $author;
        $comments && $this->comments = $comments;

        $this->getAccessProvider = new PageTemplateTags($this, $post);
        $this->setAccessProvider = new PageSetAccessProvider($this, $autoInvoker);
    }
}
