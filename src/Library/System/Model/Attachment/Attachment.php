<?php

namespace Leonidas\Library\System\Model\Attachment;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use DateTime;
use DateTimeZone;
use Leonidas\Contracts\System\Model\Attachment\AttachmentInterface;
use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Library\System\Model\Author\Author;
use Leonidas\Library\System\Model\Link\WebPage;
use Psr\Link\LinkInterface;
use WP_Post;

class Attachment implements AttachmentInterface
{
    protected WP_Post $attachment;

    public function __construct(WP_Post $attachment)
    {
        $this->attachment = $attachment;
    }

    public function getId(): int
    {
        return $this->attachment->ID;
    }

    public function getName(): string
    {
        return $this->attachment->post_name;
    }

    public function getTitle(): string
    {
        return $this->attachment->post_title;
    }

    public function getCaption(): string
    {
        return $this->attachment->post_excerpt;
    }

    public function getDescription(): string
    {
        return $this->attachment->post_content;
    }

    public function getAuthor(): AuthorInterface
    {
        return new Author(
            get_user_by('id', (int) $this->attachment->post_author)
        );
    }

    public function getDateCreated(): CarbonInterface
    {
        return new Carbon($this->attachment->post_date);
    }

    public function getDateCreatedGmt(): CarbonInterface
    {
        return new Carbon($this->attachment->post_date_gmt);
    }

    public function getDateModified(): CarbonInterface
    {
        return new Carbon($this->attachment->post_modified);
    }

    public function getDateModifiedGmt(): CarbonInterface
    {
        return new Carbon($this->attachment->post_modified_gmt);
    }

    public function getPassword(): ?string
    {
        return $this->attachment->post_password;
    }

    public function getGuid(): LinkInterface
    {
        return new WebPage($this->attachment->guid);
    }

    public function getMenuOrder(): int
    {
        return (int) $this->attachment->menu_order;
    }

    public function getMimeType(): string
    {
        return $this->attachment->post_mime_type;
    }

    public function getCommentCount(): int
    {
        return (int) $this->attachment->comment_count;
    }

    public function getFilter(): string
    {
        return $this->attachment->filter;
    }

    public function applyFilter(string $filter): void
    {
        $this->attachment->filter($filter);
    }

    public function pageTemplate(): string
    {
        return $this->attachment->page_template;
    }
}
