<?php

namespace WebTheory\Leonidas\Admin\Loaders;

use GuzzleHttp\Psr7\ServerRequest;
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
    public function hook()
    {
        $this->targetAddMetaboxesHook();

        return $this;
    }

    protected function targetAddMetaboxesHook()
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
        $request = ServerRequest::fromGlobals()
            ->withAttribute('post', $post);

        if ($this->metabox->shouldBeRendered($request)) {
            add_meta_box(
                $this->metabox->getId(),
                $this->metabox->getTitle(),
                [$this, 'renderMetabox'],
                $this->metabox->getScreen(),
                $this->metabox->getContext(),
                $this->metabox->getPriority(),
                $this->metabox->getCallBackArgs()
            );
        }
    }

    /**
     * @param WP_Post $post
     */
    public function renderMetabox(WP_Post $post, array $args): void
    {
        $request = ServerRequest::fromGlobals()
            ->withAttribute('post', $post)
            ->withAttribute('args', $args);

        echo $this->metabox->renderComponent($request);
    }
}
