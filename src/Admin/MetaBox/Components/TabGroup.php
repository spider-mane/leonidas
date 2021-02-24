<?php

namespace WebTheory\Leonidas\Admin\Metabox\Components;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\Contracts\MetaboxComponentInterface;
use WebTheory\Leonidas\Admin\Contracts\ViewInterface;
use WebTheory\Leonidas\Admin\Metabox\Views\TabGroupView;
use WebTheory\Leonidas\Admin\Traits\CanBeRestrictedTrait;
use WebTheory\Leonidas\Admin\Traits\RendersWithViewTrait;

class TabGroup implements MetaboxComponentInterface
{
    use CanBeRestrictedTrait;
    use RendersWithViewTrait;

    /**
     *
     */
    protected function getView(): ViewInterface
    {
        return new TabGroupView();
    }

    /**
     *
     */
    protected function defineViewContext(ServerRequestInterface $request): array
    {
        return [];
    }
}
