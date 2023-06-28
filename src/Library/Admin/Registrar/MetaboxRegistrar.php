<?php

namespace Leonidas\Library\Admin\Registrar;

use Leonidas\Contracts\Admin\Callback\MetaboxCallbackProviderInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxCollectionInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxInterface;
use Leonidas\Contracts\Admin\Registrar\MetaboxRegistrarInterface;
use Psr\Http\Message\ServerRequestInterface;

class MetaboxRegistrar implements MetaboxRegistrarInterface
{
    public function __construct(protected MetaboxCallbackProviderInterface $callbackProvider)
    {
        //
    }

    public function registerOne(MetaboxInterface $metabox, ServerRequestInterface $request)
    {
        if ($metabox->shouldBeRendered($request)) {
            add_meta_box(
                $metabox->getId(),
                $metabox->getTitle(),
                $this->getRenderingCallback($metabox, $request),
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

    protected function getRenderingCallback(MetaboxInterface $metabox, ServerRequestInterface $request): callable
    {
        return $this->callbackProvider->getRenderingCallback($metabox, $request);
    }
}
