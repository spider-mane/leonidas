<?php

namespace Leonidas\Library\Admin\Abstracts;

use Psr\Http\Message\ServerRequestInterface;
use WP_Screen;

trait ExpectsScreenTrait
{
    protected function getScreen(ServerRequestInterface $request): WP_Screen
    {
        return $request->getAttribute('screen');
    }

    protected function getScreenId(ServerRequestInterface $request): string
    {
        return $this->getScreen($request)->id;
    }
}
