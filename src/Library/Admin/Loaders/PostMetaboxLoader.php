<?php

namespace WebTheory\Leonidas\Library\Admin\Loaders;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use WP_Post;
use WebTheory\Leonidas\Contracts\Admin\Components\ComponentLoaderInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\MetaboxInterface;
use WebTheory\Leonidas\Traits\MaybeHandlesCsrfTrait;

class PostMetaboxLoader implements ComponentLoaderInterface
{
    use MaybeHandlesCsrfTrait;

    /**
     * @var MetaboxInterface
     */
    protected $metabox;

    /**
     *
     */
    public function __construct(MetaboxInterface $metabox)
    {
        $this->metabox = $metabox;
    }

    /**
     * Get the value of metabox
     *
     * @return MetaboxInterface
     */
    public function getMetabox(): MetaboxInterface
    {
        return $this->metabox;
    }

    /**
     *
     */
    public function hook(): PostMetaboxLoader
    {
        $this->targetAddMetaboxesHook();

        return $this;
    }

    protected function targetAddMetaboxesHook(): PostMetaboxLoader
    {
        $post = $this->metabox->getScreen();

        add_action("add_meta_boxes_{$post}", [$this, 'registerMetabox'], null, PHP_INT_MAX);

        return $this;
    }

    /**
     * Callback function to add metabox to admin ui
     *
     * @param WP_Post $post
     */
    public function registerMetabox(WP_Post $post): void
    {
        $metabox = $this->getMetabox();
        $request = $this->getServerRequest()
            ->withAttribute('post', $post);

        if ($metabox->shouldBeRendered($request)) {
            add_meta_box(
                $metabox->getId(),
                $metabox->getTitle(),
                [$this, 'renderMetabox'],
                $metabox->getScreen(),
                $metabox->getContext(),
                $metabox->getPriority(),
                $metabox->getCallBackArgs()
            );
        }
    }

    protected function getServerRequest(): ServerRequestInterface
    {
        return ServerRequest::fromGlobals();
    }

    /**
     * @param WP_Post $object
     */
    public function renderMetabox(WP_Post $object, array $metabox): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('post', $object)
            ->withAttribute('metabox', $metabox);

        echo $this->getMetabox()->renderComponent($request);
    }
}
