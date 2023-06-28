<?php

namespace Leonidas\Library\Admin\Callback;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxInterface;
use Psr\Http\Message\ServerRequestInterface;

interface MetaboxCallbackProviderInterface
{
    public function getRenderingCallback(MetaboxInterface $metabox, ServerRequestInterface $request): callable;
}
