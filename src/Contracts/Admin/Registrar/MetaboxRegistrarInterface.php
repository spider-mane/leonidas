<?php

namespace Leonidas\Contracts\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxCollectionInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxInterface;
use Psr\Http\Message\ServerRequestInterface;

interface MetaboxRegistrarInterface
{
    public function registerOne(MetaboxInterface $metabox, ServerRequestInterface $request);

    public function registerMany(MetaboxCollectionInterface $metaboxes, ServerRequestInterface $request);
}
