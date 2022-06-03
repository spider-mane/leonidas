<?php

namespace Leonidas\Framework\Bootstrap;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use Leonidas\Contracts\System\Model\Category\CategoryRepositoryInterface;
use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Contracts\System\Model\Image\ImageRepositoryInterface;
use Leonidas\Contracts\System\Model\Page\PageRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostRepositoryInterface;
use Leonidas\Contracts\System\Model\Tag\TagRepositoryInterface;
use Leonidas\Contracts\System\Model\User\UserRepositoryInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Model\Author\AuthorCollectionFactory;
use Leonidas\Library\System\Model\Author\AuthorConverter;
use Leonidas\Library\System\Model\Author\AuthorRepository;
use Leonidas\Library\System\Model\Category\CategoryCollectionFactory;
use Leonidas\Library\System\Model\Category\CategoryConverter;
use Leonidas\Library\System\Model\Category\CategoryRepository;
use Leonidas\Library\System\Model\Comment\CommentCollectionFactory;
use Leonidas\Library\System\Model\Comment\CommentConverter;
use Leonidas\Library\System\Model\Comment\CommentRepository;
use Leonidas\Library\System\Model\Image\ImageCollectionFactory;
use Leonidas\Library\System\Model\Image\ImageConverter;
use Leonidas\Library\System\Model\Image\ImageQueryFactory;
use Leonidas\Library\System\Model\Image\ImageRepository;
use Leonidas\Library\System\Model\Page\PageCollectionFactory;
use Leonidas\Library\System\Model\Page\PageConverter;
use Leonidas\Library\System\Model\Page\PageQueryFactory;
use Leonidas\Library\System\Model\Page\PageRepository;
use Leonidas\Library\System\Model\Post\PostCollectionFactory;
use Leonidas\Library\System\Model\Post\PostConverter;
use Leonidas\Library\System\Model\Post\PostQueryFactory;
use Leonidas\Library\System\Model\Post\PostRepository;
use Leonidas\Library\System\Model\Tag\TagCollectionFactory;
use Leonidas\Library\System\Model\Tag\TagConverter;
use Leonidas\Library\System\Model\Tag\TagRepository;
use Leonidas\Library\System\Model\User\UserCollectionFactory;
use Leonidas\Library\System\Model\User\UserConverter;
use Leonidas\Library\System\Model\User\UserRepository;
use Leonidas\Library\System\Schema\Comment\CommentEntityManager;
use Leonidas\Library\System\Schema\Post\PostEntityManager;
use Leonidas\Library\System\Schema\Post\PostEntityQueryManager;
use Leonidas\Library\System\Schema\Term\TermEntityManager;
use Leonidas\Library\System\Schema\User\UserEntityManager;
use Panamax\Contracts\ServiceContainerInterface;

class RegisterModelServices implements ExtensionBootProcessInterface
{
    protected const MODELS = [
        'post',
        'page',
        'image',
        'tag',
        'category',
        'user',
        'author',
        'comment',
    ];

    protected WpExtensionInterface $extension;

    protected ServiceContainerInterface $container;

    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        $this->extension = $extension;
        $this->container = $container;

        foreach (static::MODELS as $type) {
            $this->$type();
        }
    }

    protected function post(): void
    {
        $this->container->share(PostConverter::class, fn () => new PostConverter(
            $this->extension->get(AutoInvokerInterface::class)
        ));

        $this->container->share(PostRepositoryInterface::class, function () {
            $type = 'post';
            $converter = $this->extension->get(PostConverter::class);

            if (is_admin()) {
                $collection = new PostCollectionFactory();
                $manager = new PostEntityManager($type, $converter, $collection);
            } else {
                $collection = new PostQueryFactory($converter);
                $manager = new PostEntityQueryManager($type, $converter, $collection);
            }

            return new PostRepository($manager);
        });
    }

    protected function page(): void
    {
        $this->container->share(PageConverter::class, fn () => new PageConverter(
            $this->extension->get(AutoInvokerInterface::class)
        ));

        $this->container->share(PageRepositoryInterface::class, function () {
            $type = 'page';
            $converter = $this->extension->get(PageConverter::class);

            if (is_admin()) {
                $collection = new PageCollectionFactory();
                $manager = new PostEntityManager($type, $converter, $collection);
            } else {
                $collection = new PageQueryFactory($converter);
                $manager = new PostEntityQueryManager($type, $converter, $collection);
            }

            return new PageRepository($manager);
        });
    }

    protected function image(): void
    {
        $this->container->share(ImageConverter::class, fn () => new ImageConverter(
            $this->extension->get(AutoInvokerInterface::class)
        ));

        $this->container->share(ImageRepositoryInterface::class, function () {
            $type = 'attachment';
            $converter = $this->extension->get(ImageConverter::class);

            if (is_admin()) {
                $collection = new ImageCollectionFactory();
                $manager = new PostEntityManager($type, $converter, $collection);
            } else {
                $collection = new ImageQueryFactory($converter);
                $manager = new PostEntityQueryManager($type, $converter, $collection);
            }

            return new ImageRepository($manager);
        });
    }

    protected function tag(): void
    {
        $this->container->share(TagConverter::class, fn () => new TagConverter(
            $this->extension->get(AutoInvokerInterface::class)
        ));

        $this->container->share(TagRepositoryInterface::class, function () {
            $converter = $this->extension->get(TagConverter::class);
            $collection = new TagCollectionFactory();
            $manager = new TermEntityManager('post_tag', $converter, $collection);

            return new TagRepository($manager);
        });
    }

    protected function category(): void
    {
        $this->container->share(CategoryConverter::class, fn () => new CategoryConverter(
            $this->extension->get(AutoInvokerInterface::class)
        ));

        $this->container->share(CategoryRepositoryInterface::class, function () {
            $converter = $this->extension->get(CategoryConverter::class);
            $collection = new CategoryCollectionFactory();
            $manager = new TermEntityManager('category', $converter, $collection);

            return new CategoryRepository($manager);
        });
    }

    protected function user(): void
    {
        $this->container->share(UserConverter::class, fn () => new UserConverter());

        $this->container->share(UserRepositoryInterface::class, function () {
            $converter = $this->extension->get(UserConverter::class);
            $collection = new UserCollectionFactory();
            $manager = new UserEntityManager('user', $converter, $collection);

            return new UserRepository($manager);
        });
    }

    protected function author(): void
    {
        $this->container->share(AuthorConverter::class, fn () => new AuthorConverter(
            $this->extension->get(AutoInvokerInterface::class)
        ));

        $this->container->share(AuthorRepositoryInterface::class, function () {
            $converter = $this->extension->get(AuthorConverter::class);
            $collection = new AuthorCollectionFactory();
            $manager = new UserEntityManager('author', $converter, $collection);

            return new AuthorRepository($manager);
        });
    }

    protected function comment(): void
    {
        $this->container->share(CommentConverter::class, fn () => new CommentConverter(
            $this->extension->get(AutoInvokerInterface::class)
        ));

        $this->container->share(CommentRepositoryInterface::class, function () {
            $converter = $this->extension->get(CommentConverter::class);
            $collection = new CommentCollectionFactory();
            $manager = new CommentEntityManager('comment', $converter, $collection);

            return new CommentRepository($manager);
        });
    }
}
