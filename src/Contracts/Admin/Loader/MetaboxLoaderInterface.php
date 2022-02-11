<?php

namespace Leonidas\Contracts\Admin\Loader;

use Leonidas\Contracts\Admin\Components\MetaboxInterface;
use Leonidas\Contracts\Admin\MetaboxCollectionInterface;
use Psr\Http\Message\ServerRequestInterface;

interface MetaboxLoaderInterface
{
    public function registerOne(MetaboxInterface $metabox, ServerRequestInterface $request);

    public function registerMany(MetaboxCollectionInterface $metaboxes, ServerRequestInterface $request);
}
