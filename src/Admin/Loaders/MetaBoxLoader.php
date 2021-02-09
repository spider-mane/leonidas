<?php

namespace WebTheory\Leonidas\Admin\Loaders;

use GuzzleHttp\Psr7\ServerRequest;
use WebTheory\Leonidas\Admin\Contracts\ComponentLoaderInterface;
use WebTheory\Leonidas\Admin\Contracts\MetaBoxInterface;
use WebTheory\Leonidas\Core\Traits\HasNonceTrait;

class MetaBoxLoader implements ComponentLoaderInterface
{
    use HasNonceTrait;

    /**
     * screen
     *
     * @var string
     */
    protected $screen;

    /**
     * metaBoxes
     *
     * @var MetaBoxInterface[]
     */
    protected $metaBoxes = [];

    /**
     *
     */
    public const ARG_KEY = 'leonidas.metabox';

    /**
     *
     */
    public function __construct(string $screen)
    {
        $this->screen = $screen;
    }

    /**
     * Get screen
     *
     * @return string|array
     */
    public function getScreen()
    {
        return $this->screen;
    }

    /**
     * @var MetaBoxInterface[]
     */
    public function getMetaBoxes(): array
    {
        return $this->metaBoxes;
    }

    /**
     *
     */
    public function addMetaBox(MetaBoxInterface $metabox)
    {
        $this->metaBoxes[$metabox->getId()] = $metabox;
    }

    /**
     *
     */
    public function hook()
    {
        add_action("add_meta_boxes", [$this, 'registerMetaBoxes']);

        return $this;
    }

    /**
     * Callback function to add metabox to admin ui
     *
     * @param $post
     */
    public function registerMetaBoxes()
    {
        foreach ($this->metaBoxes as $metaBox) {
            add_meta_box(
                $metaBox->getId(),
                $metaBox->getTitle(),
                [$this, 'renderMetabox'],
                $metaBox->getScreen(),
                $metaBox->getContext(),
                $metaBox->getPriority(),
                $metaBox->getCallBackArgs() + [static::ARG_KEY => $metaBox]
            );
        }

        return $this;
    }

    /**
     *
     */
    public function renderMetabox($post, $postId, $metabox)
    {
        /** @var MetaBoxInterface $metabox */
        $metabox = $this->metaBoxes[$metabox[static::ARG_KEY]];

        $request = ServerRequest::fromGlobals()->withAttribute('post', $post);

        echo $metabox->renderComponent($request);
    }
}
