<?php

namespace Leonidas\Library\System\Post;

use DateTime;
use DateTimeInterface;
use Exception;
use Leonidas\Contracts\System\Post\PostInterface;
use Leonidas\Contracts\System\User\UserInterface;
use Leonidas\Library\Domain\Interfaces\PostDataProviderInterface;
use Leonidas\Library\System\Traits\DefersResolutionTrait;
use WP_Post;

class Post implements PostInterface
{
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

    public function getDateCreated(): DateTimeInterface
    {
        return new DateTime($this->post->post_date);
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

    public function __get($name)
    {
        $getter = 'get' . ucfirst($name);

        try {
            return ($this->$getter)($name);
        } catch (Exception $e) {
            return;
        }
    }
}
