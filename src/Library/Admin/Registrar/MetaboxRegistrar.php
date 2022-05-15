<?php

namespace Leonidas\Library\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\MetaboxInterface;
use Leonidas\Contracts\Admin\MetaboxCollectionInterface;
use Leonidas\Contracts\Admin\Registrar\MetaboxRegistrarInterface;
use Leonidas\Library\Admin\Registrar\Abstracts\AbstractRegistrar;
use Psr\Http\Message\ServerRequestInterface;

class MetaboxRegistrar extends AbstractRegistrar implements MetaboxRegistrarInterface
{
    public function registerOne(MetaboxInterface $metabox, ServerRequestInterface $request)
    {
        if ($metabox->shouldBeRendered($request)) {
            add_meta_box(
                $metabox->getId(),
                $metabox->getTitle(),
                $this->getOutputLoader(),
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
