<?php

namespace Leonidas\Contracts\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\MetaboxInterface;
use Leonidas\Contracts\Admin\MetaboxCollectionInterface;
use Psr\Http\Message\ServerRequestInterface;

interface MetaboxRegistrarInterface
{
    public function registerOne(MetaboxInterface $metabox, ServerRequestInterface $request);

    public function registerMany(MetaboxCollectionInterface $metaboxes, ServerRequestInterface $request);
}
