<?php

namespace Leonidas\Library\Admin\Metabox;

use Psr\Http\Message\ServerRequestInterface;
use Leonidas\Contracts\Admin\Components\MetaboxContainerInterface;
use Leonidas\Contracts\Admin\MetaboxCollectionInterface;

class StandardMetaboxContainer implements MetaboxContainerInterface
{
    /**
     * @var MetaboxCollectionInterface
     */
    protected $metaboxes;

    public function __construct(MetaboxCollectionInterface $metaboxes)
    {
        $this->metaboxes = $metaboxes;
    }

    public function renderComponent(ServerRequestInterface $request): string
    {
        return '';
    }
}
