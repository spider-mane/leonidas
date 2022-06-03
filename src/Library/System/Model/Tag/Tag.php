<?php

namespace Leonidas\Library\System\Model\Tag;

use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostRepositoryInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Model\Abstracts\AllAccessGrantedTrait;
use Leonidas\Library\System\Model\Abstracts\LazyLoadableRelationshipsTrait;
use Leonidas\Library\System\Model\Abstracts\Term\MutableTermModelTrait;
use Leonidas\Library\System\Model\Abstracts\Term\ValidatesTaxonomyTrait;
use WP_Term;

class Tag implements TagInterface
{
    use AllAccessGrantedTrait;
    use LazyLoadableRelationshipsTrait;
    use MutableTermModelTrait;
    use ValidatesTaxonomyTrait;

    protected WP_Term $term;

    protected PostCollectionInterface $posts;

    public function __construct(
        WP_Term $term,
        AutoInvokerInterface $autoInvoker,
        ?PostCollectionInterface $posts = null
    ) {
        $this->assertTaxonomy($term, 'post_tag');

        $this->term = $term;
        $this->autoInvoker = $autoInvoker;

        $posts && $this->posts = $posts;

        $this->getAccessProvider = new TagGetAccessProvider($this);
        $this->setAccessProvider = new TagSetAccessProvider($this);
    }

    public function getDescription(): string
    {
        return $this->term->description;
    }

    public function setDescription(string $description): self
    {
        $this->term->description = $description;

        return $this;
    }

    public function getPosts(): PostCollectionInterface
    {
        return $this->lazyLoadable('posts', fn (
            PostRepositoryInterface $posts
        ) => $posts->whereTag($this));
    }

    public function setPosts(PostCollectionInterface $posts): TagInterface
    {
        $this->posts = $posts;

        return $this;
    }
}
