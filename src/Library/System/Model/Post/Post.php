<?php

namespace Leonidas\Library\System\Model\Post;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use DateTime;
use DateTimeInterface;
use Exception;
use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Library\System\Schema\Traits\HasTermsTrait;
use WP_Post;

class Post implements PostInterface
{
    use HasTermsTrait;

    protected WP_Post $post;

    public function __construct(WP_Post $post)
    {
        $this->post = $post;
    }

    public function getId(): int
    {
        return $this->post->ID;
    }

    public function getTitle(): string
    {
        return $this->post->post_title;
    }

    public function setTitle(string $title)
    {
        $this->post->post_title = $title;

        return $this;
    }

    public function getContent(): string
    {
        return $this->post->post_content;
    }

    public function setContent(string $content)
    {
        $this->post->post_content = $content;

        return $this;
    }

    public function getExcerpt(): string
    {
        return $this->post->post_excerpt;
    }

    public function setExcerpt(string $excerpt)
    {
        $this->post->post_excerpt = $excerpt;

        return $this;
    }

    public function getAuthor(): UserInterface
    {
        return $this->post->post_author;
    }

    public function setAuthor(UserInterface $author)
    {
        $this->post->post_author = $author;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->post->post_status;
    }

    public function setStatus(string $status)
    {
        $this->post->post_status = $status;

        return $this;
    }

    public function getAllowsComments(): bool
    {
        return $this->post->comment_status;
    }

    public function setAllowsComments(bool $allowsComments)
    {
        $this->post->comment_status = $allowsComments;

        return $this;
    }

    public function getDateCreated(): CarbonInterface
    {
        return new Carbon($this->post->post_date);
    }

    public function setDateCreated(DateTimeInterface $dateCreated)
    {
        $this->post->post_date = $dateCreated->getTimestamp();

        return $this;
    }

    public function getDateModified(): DateTimeInterface
    {
        return new DateTime($this->post->post_modified);
    }

    public function setDateModified(DateTimeInterface $dateModified)
    {
        $this->post->post_modified = $dateModified->getTimestamp();

        return $this;
    }

    public function getParent(): ?Post
    {
        return $this->post->post_parent;
    }

    public function setParent(?Post $parent)
    {
        $this->post->post_parent = $parent->getName();

        return $this;
    }

    public function getMenuOrder(): int
    {
        return $this->post->menu_order;
    }

    public function getCategories(): CategoryCollectionInterface
    {
        return $this->getTerms('category');
    }

    protected function gettable(): array
    {
        return [
            'id',
            'author',
            'date',
            'dateGmt',
            'content',
            'title',
            'excerpt',
            'status',
            'commentStatus',
            'pingStatus',
            'password',
            'name',
            'pingQueue',
            'dateModified',
            'dateModifiedGmt',
            'contentFiltered',
            'parent',
            'guid',
            'menuOrder',
            'postType',
            'mimeType',
            'commentCount',
            'filter',
        ];
    }

    protected function settable(): array
    {
        return [
            'id',
            'author',
            'date',
            'dateGmt',
            'content',
            'title',
            'excerpt',
            'status',
            'commentStatus',
            'pingStatus',
            'password',
            'name',
            'pingQueue',
            'dateModified',
            'dateModifiedGmt',
            'contentFiltered',
            'parent',
            'guid',
            'menuOrder',
            'postType',
            'mimeType',
            'commentCount',
            'filter',
        ];
    }

    public function __get($name)
    {
        if (!in_array($name, $this->gettable())) {
            return;
        }

        return ([$this, 'get' . ucfirst($name)])($name);
    }

    public function __set($name)
    {
        if (!in_array($name, $this->settable())) {
            return;
        }

        ([$this, 'set' . ucfirst($name)])($name);
    }
}
