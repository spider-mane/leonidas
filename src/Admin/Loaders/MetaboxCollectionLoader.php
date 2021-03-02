<?php

namespace WebTheory\Leonidas\Admin\Loaders;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
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
    public function __construct(MetaboxInterface ...$metaboxes)
    {
        foreach ($metaboxes as $metabox) {
            $this->addMetabox($metabox);
        }
    }

    /**
     * Get stored collection of MetaboxInterface instances
     *
     * @return MetaboxInterface[]
     */
    public function getMetaboxes(): array
    {
        return $this->metaboxes;
    }

    /**
     * Add metabox to the stored collection of metaboxes to be loaded.
     * @param MetaboxInterface $metabox
     * @return MetaboxCollectionLoader
     */
    public function addMetabox(MetaboxInterface $metabox): MetaboxCollectionLoader
    {
        $this->metaboxes[$metabox->getId()] = $metabox;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function hook(): MetaboxCollectionLoader
    {
        $this->targetAddMetaboxesHook();

        return $this;
    }

    /**
     * Register callback function to register metaboxes in $metaboxes property.
     */
    protected function targetAddMetaboxesHook(): MetaboxCollectionLoader
    {
        add_action("add_meta_boxes", [$this, 'registerMetaboxes'], null, PHP_INT_MAX);

        return $this;
    }

    /**
     * Callback function to add metabox to admin ui. Conditionally registers
     * metaboxes from $metaboxes property.
     *
     * @param $post
     */
    public function registerMetaboxes(string $postType, WP_Post $post): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('post_type', $postType)
            ->withAttribute('post', $post);

        foreach ($this->getMetaBoxes() as $metabox) {
            if ($this->metaboxShouldBeRendered($metabox, $request)) {
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
    }

    /**
     * Determine whether or not the passed metabox should be loaded.
     */
    protected function metaboxShouldBeRendered(MetaboxInterface $metabox, ServerRequestInterface $request): bool
    {
        return $metabox->shouldBeRendered($request);
    }

    /**
     * Callback function to render output of current metabox.
     *
     * @param WP_Post $post
     *
     * @return void
     */
    public function renderMetabox(WP_Post $post, array $metabox): void
    {
        $cachedMetabox = $this->getCorrespondingMetabox($metabox);

        if ($cachedMetabox) {
            $request = $this->getServerRequest()
                ->withAttribute('post', $post)
                ->withAttribute('metabox', $metabox);

            echo $cachedMetabox->renderComponent($request);
        }
    }

    /**
     * Determines which metabox in the $metaboxes property corresponds to the
     * metabox that's currently being loaded in the admin.
     */
    protected function getCorrespondingMetabox(array $metabox): ?MetaboxInterface
    {
        return $this->metaboxes[$metabox['id']] ?? null;
    }

    /**
     * Return a ServerRequestInterface object
     */
    protected function getServerRequest(): ServerRequestInterface
    {
        return ServerRequest::fromGlobals();
    }
}
