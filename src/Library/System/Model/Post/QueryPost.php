<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Library\Core\Util\OutputBuffer;
use Psr\Link\LinkInterface;

class QueryPost extends Post implements PostInterface
{
    public function __construct()
    {
        $this->post = $GLOBALS['post'];
    }

    public function getId(): int
    {
        return OutputBuffer::wrapFunction('the_ID');
    }

    public function getTitle(): string
    {
        return OutputBuffer::wrapFunction('the_title');
    }

    public function getContent(): string
    {
        return OutputBuffer::wrapFunction('the_content');
    }

    public function getExcerpt(): string
    {
        return OutputBuffer::wrapFunction('the_excerpt');
    }

    public function hasExcerpt(): bool
    {
        return has_excerpt();
    }

    public function getClass(string $class = '')
    {
        return OutputBuffer::wrapFunction('post_class', $class);
    }

    public function getGuid(): LinkInterface
    {
        return OutputBuffer::wrapFunction('the_guid');
    }

    public function passwordRequired(): bool
    {
        return post_password_required();
    }
}
