<?php

namespace Leonidas\Contracts\Ui\Asset;

use Psr\Http\Message\ServerRequestInterface;

interface StyleLoaderInterface
{
    public function load(StyleCollectionInterface $style, ServerRequestInterface $request);

    public function support(InlineStyleCollectionInterface $style, ServerRequestInterface $request);
}
