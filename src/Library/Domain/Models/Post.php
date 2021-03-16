<?php

namespace Leonidas\Library\Domain\Models;

use DateTimeInterface;
use Leonidas\Library\Domain\Interfaces\PostInterface;

class Post implements PostInterface
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $excerpt;

    /**
     * @var User
     */
    protected $author;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var bool
     */
    protected $allowsComments;

    /**
     * @var DateTimeInterface
     */
    protected $dateCreated;

    /**
     * @var DateTimeInterface
     */
    protected $dateModified;

    /**
     * @var null|Post
     */
    protected $parent;

    /**
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the value of title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of content
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @param string $content
     *
     * @return self
     */
    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of excerpt
     *
     * @return string
     */
    public function getExcerpt(): string
    {
        return $this->excerpt;
    }

    /**
     * Set the value of excerpt
     *
     * @param string $excerpt
     *
     * @return self
     */
    public function setExcerpt(string $excerpt)
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    /**
     * Get the value of author
     *
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @param User $author
     *
     * @return self
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get the value of status
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param string $status
     *
     * @return self
     */
    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of allowsComments
     *
     * @return bool
     */
    public function getAllowsComments(): bool
    {
        return $this->allowsComments;
    }

    /**
     * Set the value of allowsComments
     *
     * @param bool $allowsComments
     *
     * @return self
     */
    public function setAllowsComments(bool $allowsComments)
    {
        $this->allowsComments = $allowsComments;

        return $this;
    }

    /**
     * Get the value of dateCreated
     *
     * @return DateTimeInterface
     */
    public function getDateCreated(): DateTimeInterface
    {
        return $this->dateCreated;
    }

    /**
     * Set the value of dateCreated
     *
     * @param DateTimeInterface $dateCreated
     *
     * @return self
     */
    public function setDateCreated(DateTimeInterface $dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get the value of dateModified
     *
     * @return DateTimeInterface
     */
    public function getDateModified(): DateTimeInterface
    {
        return $this->dateModified;
    }

    /**
     * Set the value of dateModified
     *
     * @param DateTimeInterface $dateModified
     *
     * @return self
     */
    public function setDateModified(DateTimeInterface $dateModified)
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * Get the value of parent
     *
     * @return null|Post
     */
    public function getParent(): ?Post
    {
        return $this->parent;
    }

    /**
     * Set the value of parent
     *
     * @param null|Post $parent
     *
     * @return self
     */
    public function setParent(?Post $parent)
    {
        $this->parent = $parent;

        return $this;
    }
}
