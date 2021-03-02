<?php

namespace WebTheory\Leonidas\Admin\Loaders;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use WP_Post;
use WebTheory\Leonidas\Admin\Contracts\ComponentLoaderInterface;
use WebTheory\Leonidas\Admin\Contracts\MetaboxInterface;
use WebTheory\Leonidas\Core\Traits\HasNonceTrait;

class MetaboxLoader implements ComponentLoaderInterface
{
    use HasNonceTrait;

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
     *
     */
    public function hook(): MetaboxLoader
    {
        $this->targetAddMetaboxesHook();

        return $this;
    }

    protected function targetAddMetaboxesHook(): MetaboxLoader
    {
        $postType = $this->metabox->getScreen();

        add_action("add_meta_boxes_{$postType}", [$this, 'registerMetabox'], null, PHP_INT_MAX);

        return $this;
    }

    /**
     * Callback function to add metabox to admin ui
     *
     * @param $post
     */
    public function registerMetabox(WP_Post $post): void
    {
        $metabox = $this->metabox;
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

    /**
     * @param WP_Post $post
     */
    public function renderMetabox(WP_Post $post, array $metabox): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('post', $post)
            ->withAttribute('metabox', $metabox);

        echo $this->metabox->renderComponent($request);
    }

    protected function getServerRequest(): ServerRequestInterface
    {
        return ServerRequest::fromGlobals();
    }
}
