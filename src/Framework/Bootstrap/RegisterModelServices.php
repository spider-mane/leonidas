<?php

namespace Leonidas\Framework\Bootstrap;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Framework\Bootstrap\Abstracts\AbstractModelRegistrar;
use Leonidas\Library\System\Model\Author\Author;
use Leonidas\Library\System\Model\Category\Category;
use Leonidas\Library\System\Model\Comment\Comment;
use Leonidas\Library\System\Model\Image\Image;
use Leonidas\Library\System\Model\Page\Page;
use Leonidas\Library\System\Model\Post\Post;
use Leonidas\Library\System\Model\Tag\Tag;
use Leonidas\Library\System\Model\User\User;

class RegisterModelServices extends AbstractModelRegistrar implements ExtensionBootProcessInterface
{
    protected const CONTRACTS = 'Leonidas\Contracts\System\Model';

    protected const MODELS = 'Leonidas\Library\System\Model';

    protected function postServices(): void
    {
        $this->register(Post::class, 'post', 'post');
    }

    protected function pageServices(): void
    {
        $this->register(Page::class, 'page', 'post');
    }

    protected function imageServices(): void
    {
        $this->register(Image::class, 'attachment', 'attachment', []);
    }

    protected function tagServices(): void
    {
        $this->register(Tag::class, 'post_tag', 'term');
    }

    protected function categoryServices(): void
    {
        $this->register(Category::class, 'category', 'term');
    }

    protected function userServices(): void
    {
        $this->register(User::class, 'user', 'user');
    }

    protected function authorServices(): void
    {
        $this->register(Author::class, 'author', 'user');
    }

    protected function commentServices(): void
    {
        $this->register(Comment::class, 'comment', 'comment');
    }
}
