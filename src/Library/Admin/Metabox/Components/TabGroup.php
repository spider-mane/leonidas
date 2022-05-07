<?php

namespace Leonidas\Library\Admin\Metabox\Components;

use Leonidas\Contracts\Admin\Components\MetaboxComponentInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Admin\Abstracts\RendersWithViewTrait;
use Leonidas\Library\Admin\Metabox\Views\TabGroupView;
use Psr\Http\Message\ServerRequestInterface;

class TabGroup implements MetaboxComponentInterface
{
    use CanBeRestrictedTrait;
    use RendersWithViewTrait;

    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        return new TabGroupView();
    }

    protected function defineViewContext(ServerRequestInterface $request): array
    {
        return [];
    }
}
