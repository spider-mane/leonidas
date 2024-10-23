<?php

namespace Leonidas\Contracts\System\Model\Post;

use Leonidas\Contracts\System\Model\Category\HasManyMutableCategoriesInterface;
use Leonidas\Contracts\System\Model\CommentableInterface;
use Leonidas\Contracts\System\Model\FilterableInterface;
use Leonidas\Contracts\System\Model\MimeInterface;
use Leonidas\Contracts\System\Model\MutableAuthoredInterface;
use Leonidas\Contracts\System\Model\MutableContentInterface;
use Leonidas\Contracts\System\Model\MutableDatableInterface;
use Leonidas\Contracts\System\Model\MutablePostModelInterface;
use Leonidas\Contracts\System\Model\MutableTitledInterface;
use Leonidas\Contracts\System\Model\PingableInterface;
use Leonidas\Contracts\System\Model\Post\Status\PostStatusInterface;
use Leonidas\Contracts\System\Model\RestrictableInterface;
use Leonidas\Contracts\System\Model\Tag\HasManyMutableTagsInterface;
use Stringable;

interface PostInterface extends
    CommentableInterface,
    FilterableInterface,
    MimeInterface,
    MutableAuthoredInterface,
    HasManyMutableCategoriesInterface,
    MutableContentInterface,
    MutableDatableInterface,
    MutablePostModelInterface,
    HasManyMutableTagsInterface,
    MutableTitledInterface,
    PingableInterface,
    RestrictableInterface,
    Stringable
{
    public function getExcerpt(): string;

    public function setExcerpt(string $excerpt): self;

    public function getStatus(): PostStatusInterface;

    public function setStatus(PostStatusInterface $status): self;
}
