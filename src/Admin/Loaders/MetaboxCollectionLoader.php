<?php

namespace WebTheory\Leonidas\Admin\Loaders;

use GuzzleHttp\Psr7\ServerRequest;
use WP_Post;
use WebTheory\Leonidas\Admin\Contracts\MetaboxCollectionLoaderInterFace;
use WebTheory\Leonidas\Admin\Contracts\MetaboxInterface;
use WebTheory\Leonidas\Core\Traits\HasNonceTrait;

class MetaboxCollectionLoader implements MetaboxCollectionLoaderInterFace
{
    use HasNonceTrait;

    /**
     * Collection of metaboxes
     *
     * @var MetaboxInterface[]
     */
    protected $metaboxes = [];

    /**
     *
     */
    protected const CACHED_METABOX_KEY = 'leonidas.metabox';

    /**
     *
     */
    public function __construct(MetaboxInterface ...$metaboxes)
    {
        $this->metaboxes = $metaboxes;
    }

    /**
     * @return MetaboxInterface[]
     */
    public function getMetaboxes(): array
    {
        return $this->metaboxes;
    }

    /**
     *
     */
    public function addMetabox(MetaboxInterface $metabox)
    {
        $this->metaboxes[$metabox->getId()] = $metabox;
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
        add_action("add_meta_boxes", [$this, 'registerMetaboxes'], null, PHP_INT_MAX);
    }

    /**
     * Callback function to add metabox to admin ui
     *
     * @param $post
     */
    public function registerMetaboxes(string $postType, WP_Post $post): void
    {
        $request = ServerRequest::fromGlobals()
            ->withAttribute('post_type', $postType)
            ->withAttribute('post', $post);

        foreach ($this->getMetaBoxes() as $metabox) {
            if ($metabox->shouldBeRendered($request)) {
                add_meta_box(
                    $metabox->getId(),
                    $metabox->getTitle(),
                    [$this, 'renderMetabox'],
                    $metabox->getScreen(),
                    $metabox->getContext(),
                    $metabox->getPriority(),
                    $this->getMetaboxArgsCacheEntry($metabox) + $metabox->getCallBackArgs()
                );
            }
        }

        return $this;
    }

    /**
     * Define args required to properly identify and render metabox in callback
     */
    protected function getMetaboxArgsCacheEntry(MetaboxInterface $metabox): array
    {
        return [static::CACHED_METABOX_KEY => $metabox->getId()];
    }

    /**
     * Callback function for the add_meta_boxes event.
     *
     * @param WP_Post $post
     *
     * @return void
     */
    public function renderMetabox(WP_Post $post, array $args): void
    {
        $cashedMetabox = $args[static::CACHED_METABOX_KEY];

        /** @var MetaboxInterface $metabox */
        $metabox = $this->metaboxes[$cashedMetabox] ?? null;

        if ($metabox) {
            unset($args[static::CACHED_METABOX_KEY]);

            $request = ServerRequest::fromGlobals()
                ->withAttribute('post', $post)
                ->withAttribute('args', $args);

            echo $metabox->renderComponent($request);
        }
    }
}
