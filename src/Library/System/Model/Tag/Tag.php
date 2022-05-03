<?php

namespace Leonidas\Library\System\Model\Tag;

use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostRepositoryInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;
use Leonidas\Library\System\Model\Abstracts\Term\MutableTermModelTrait;
use Leonidas\Library\System\Model\Abstracts\Term\ValidatesTaxonomyTrait;
use ReturnTypeWillChange;
use WP_Term;

class Tag implements TagInterface
{
    use MutableTermModelTrait;
    use ValidatesTaxonomyTrait;

    protected WP_Term $term;

    protected PostCollectionInterface $posts;

    protected PostRepositoryInterface $postRepository;

    protected GetAccessProviderInterface $getAccessProvider;

    protected SetAccessProviderInterface $setAccessProvider;

    protected string $taxonomyPrefix = '';

    public function __construct(WP_Term $term, PostRepositoryInterface $postRepository, string $taxonomyPrefix = '')
    {
        $this->validateTaxonomy($term, $taxonomyPrefix . 'post_tag');

        $this->term = $term;
        $this->postRepository = $postRepository;
        $this->taxonomyPrefix = $taxonomyPrefix;

        $this->getAccessProvider = new TagGetAccessProvider($this);
        $this->setAccessProvider = new TagSetAccessProvider($this);
    }

    #[ReturnTypeWillChange]
    public function __get($name)
    {
        return $this->getAccessProvider->get($name);
    }

    public function __set($name, $value): void
    {
        $this->setAccessProvider->set($name, $value);
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
        return $this->posts ??= $this->getPostsFromRepository();
    }

    public function setPosts(PostCollectionInterface $posts): TagInterface
    {
        $this->posts = $posts;

        return $this;
    }

    protected function getPostsFromRepository(): PostCollectionInterface
    {
        return $this->postRepository->withTag($this);
    }
}
