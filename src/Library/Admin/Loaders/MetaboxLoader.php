<?php

namespace Leonidas\Library\Admin\Loaders;

use GuzzleHttp\Psr7\ServerRequest;
use Leonidas\Contracts\Admin\ComponentLoaderInterface;
use Leonidas\Contracts\Admin\Components\MetaboxInterface;
use Leonidas\Contracts\Admin\Loader\MetaboxLoaderInterface;
use Leonidas\Contracts\Admin\MetaboxCollectionInterface;
use Leonidas\Traits\MaybeHandlesCsrfTrait;
use Psr\Http\Message\ServerRequestInterface;
use WP_Post;

class MetaboxLoader implements MetaboxLoaderInterface
{
    /**
     * @var callable
     */
    protected $renderFunction;

    public function __construct(callable $renderFunction)
    {
        $this->renderFunction = $renderFunction;
    }

    public function getRenderFunction(): callable
    {
        return $this->renderFunction;
    }

    public function registerOne(MetaboxInterface $metabox, ServerRequestInterface $request)
    {
        if ($metabox->shouldBeRendered($request)) {
            add_meta_box(
                $metabox->getId(),
                $metabox->getTitle(),
                $this->getRenderFunction(),
                $metabox->getScreen(),
                $metabox->getContext(),
                $metabox->getPriority(),
                $metabox->getArgs()
            );
        }
    }

    public function registerMany(MetaboxCollectionInterface $metaboxes, ServerRequestInterface $request)
    {
        foreach ($metaboxes->getMetaboxes() as $metabox) {
            $this->registerOne($metabox, $request);
        }
    }
}
