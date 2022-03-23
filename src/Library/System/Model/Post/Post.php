<?php

namespace Leonidas\Library\System\Model\Post;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use DateTimeInterface;
use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Contracts\System\Model\Post\PostStatusInterface;
use Leonidas\Contracts\System\Model\PostType\PostTypeInterface;
use Leonidas\Contracts\System\Model\Tag\TagCollectionInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Library\System\Model\Category\CategoryCollection;
use Leonidas\Library\System\Model\PostType\AdaptedPostType;
use Leonidas\Library\System\Model\Tag\TagCollection;
use Leonidas\Library\System\Model\User\User;
use Leonidas\Library\System\Schema\Traits\HasTermsTrait;
use Library\System\Model\Post\PostStatus;
use Psr\Link\LinkInterface;
use WP_Post;

class Post implements PostInterface
{
    use HasTermsTrait;

    protected WP_Post $post;

    public function __construct(WP_Post $post)
    {
        $this->post = $post;
    }

    public function __get($name)
    {
        if (!in_array($name, $this->gettableProperties())) {
            return;
        }

        return ([$this, 'get' . ucfirst($name)])($name);
    }

    public function __set($name)
    {
        if (!in_array($name, $this->settableProperties())) {
            return;
        }

        ([$this, 'set' . ucfirst($name)])($name);
    }

    public function __toString()
    {
        return $this->getContent();
    }

    public function getId(): int
    {
        return $this->post->ID;
    }

    public function getName(): string
    {
        return $this->post->post_name;
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
        return User::fromId((int) $this->post->post_author);
    }

    public function setAuthor(UserInterface $author)
    {
        $this->post->post_author = $author->getId();

        return $this;
    }

    public function getStatus(): PostStatusInterface
    {
        return new PostStatus($this->post->post_status);
    }

    public function setStatus(PostStatusInterface $status)
    {
        $this->post->post_status = $status->getName();

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

    public function getDate(): CarbonInterface
    {
        return new Carbon($this->post->post_date);
    }

    public function setDate(DateTimeInterface $dateCreated)
    {
        $this->post->post_date = $dateCreated->getTimestamp();

        return $this;
    }

    public function getDateGmt(): CarbonInterface
    {
        return new Carbon($this->post->post_date_gmt);
    }

    public function setDateGmt(DateTimeInterface $date)
    {
        $this->post->post_date_gmt = $date->getTimestamp();
    }

    public function getDateModified(): CarbonInterface
    {
        return new Carbon($this->post->post_modified);
    }

    public function setDateModified(DateTimeInterface $date)
    {
        $this->post->post_modified = $date->getTimestamp();

        return $this;
    }

    public function getParent(): ?Post
    {
        return static::fromId($this->post->post_parent);
    }

    public function setParent(?Post $parent)
    {
        $this->post->post_parent = $parent->getId();

        return $this;
    }

    public function getMenuOrder(): int
    {
        return $this->post->menu_order;
    }

    public function getCategories(): CategoryCollectionInterface
    {
        return CategoryCollection::adapt($this->getTerms('category'));
    }

    public function getTags(): TagCollectionInterface
    {
        return TagCollection::adapt($this->getTerms('post_tag'));
    }

    public function getPostType(): PostTypeInterface
    {
        return AdaptedPostType::fromName($this->post->post_type);
    }

    public function getCommentCount(): int
    {
        return $this->post->comment_count;
    }

    public function getContentFiltered(): string
    {
        return $this->post->post_content_filtered;
    }

    public function getDateModifiedGmt(): DateTimeInterface
    {
        return new Carbon($this->post->post_modified_gmt);
    }

    public function getFilter(): string
    {
        return $this->post->filter;
    }

    public function getGuid(): LinkInterface
    {
        return new PostGuid($this->post->guid);
    }

    public function getMimeType(): string
    {
        return $this->post->post_mime_type;
    }

    public function getParentId(): int
    {
        return $this->post->post_parent;
    }

    public function getPingStatus(): string
    {
        return $this->post->ping_status;
    }

    public function getPostFormat(): string
    {
        return $this->post->post_format;
    }

    public function getPassword(): ?string
    {
        return $this->post->post_password;
    }

    public function toPing(): string
    {
        return $this->post->to_ping;
    }

    public function hasBeenPinged(): bool
    {
        return $this->post->pinged;
    }

    public function pageTemplate(): string
    {
        return $this->post->page_template;
    }

    public function getMeta(string $key): string
    {
        return get_post_meta($this->post->ID, $key, true);
    }

    public function setMeta(string $key, string $value)
    {
        update_post_meta($this->post->ID, $key, $value);

        return $this;
    }

    public function getMetaData(): array
    {
        return get_post_meta($this->post->ID);
    }

    protected function gettableProperties(): array
    {
        return [
            'id',
            'author',
            'date',
            'dateGmt',
            'date_gmt',
            'content',
            'title',
            'excerpt',
            'status',
            'commentStatus',
            'comment_status',
            'pingStatus',
            'ping_status',
            'password',
            'name',
            'pingQueue',
            'pinged',
            'dateModified',
            'date_modified',
            'dateModifiedGmt',
            'date_modified_gmt',
            'contentFiltered',
            'content_filtered',
            'parent',
            'guid',
            'menuOrder',
            'menu_order',
            'postType',
            'post_type',
            'mimeType',
            'mime_type',
            'commentCount',
            'comment_count',
            'filter',
        ];
    }

    protected function settableProperties(): array
    {
        return [
            'id',
            'author',
            'date',
            'dateGmt',
            'date_gmt',
            'content',
            'title',
            'excerpt',
            'status',
            'commentStatus',
            'comment_status',
            'pingStatus',
            'ping_status',
            'password',
            'name',
            'pingQueue',
            'pinged',
            'dateModified',
            'date_modified',
            'dateModifiedGmt',
            'date_modified_gmt',
            'contentFiltered',
            'content_filtered',
            'parent',
            'guid',
            'menuOrder',
            'menu_order',
            'postType',
            'post_type',
            'mimeType',
            'mime_type',
            'commentCount',
            'comment_count',
            'filter',
        ];
    }

    public static function fromId(int $id): PostInterface
    {
        return new static(get_post($id));
    }
}
