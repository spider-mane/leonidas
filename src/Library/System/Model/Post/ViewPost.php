<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Library\System\Schema\Post\Traits\UsesPostTemplateTagsTrait;
use Psr\Link\LinkInterface;

class ViewPost extends Post implements PostInterface
{
    use UsesPostTemplateTagsTrait;

    public function getId(): int
    {
        return $this->doPostTemplateTag('the_ID', true);
    }

    public function getTitle(): string
    {
        return $this->doPostTemplateTag('the_title', true);
    }

    public function getContent(): string
    {
        return $this->doPostTemplateTag('the_content', true);
    }

    public function getExcerpt(): string
    {
        return $this->doPostTemplateTag('the_excerpt', true);
    }

    public function hasExcerpt(): bool
    {
        return $this->doPostTemplateTag('has_excerpt', false);
    }

    public function getClass()
    {
        return $this->doPostTemplateTag('post_class', true);
    }

    public function getGuid(): LinkInterface
    {
        return new PostGuid($this->doPostTemplateTag('the_guid', true));
    }

    public function passwordRequired(): bool
    {
        return $this->doPostTemplateTag('post_password_required', false);
    }
}
