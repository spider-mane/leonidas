<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use Leonidas\Contracts\System\Model\PostType\PostTypeInterface;
use Leonidas\Library\System\Model\Abstracts\LazyLoadableRelationshipsTrait;
use Leonidas\Library\System\Model\Link\WebPage;
use Leonidas\Library\System\Model\PostType\AdaptedPostType;
use Psr\Link\LinkInterface;
use WP_Post;

trait PostModelTrait
{
    use LazyLoadableRelationshipsTrait;
    use MappedToWpPostTrait;

    protected PostTypeInterface $postType;

    public function getId(): int
    {
        return $this->post->ID ?? 0;
    }

    public function getCore(): WP_Post
    {
        return $this->post;
    }

    public function getName(): string
    {
        return $this->post->post_name;
    }

    public function getTitle(): string
    {
        return $this->post->post_title;
    }

    public function getPostType(): PostTypeInterface
    {
        return $this->lazyLoadable('postType');
    }

    public function getGuid(): LinkInterface
    {
        return new WebPage($this->post->guid);
    }

    public function getMenuOrder(): int
    {
        return $this->post->menu_order;
    }

    public function getPageTemplate(): string
    {
        return $this->post->page_template;
    }

    protected function getPostTypeFromRepository(): PostTypeInterface
    {
        return AdaptedPostType::fromName($this->post->post_type);
    }
}