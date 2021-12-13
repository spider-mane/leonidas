<?php

namespace Leonidas\Contracts\Ui\Asset;

use Psr\Http\Message\ServerRequestInterface;

interface StyleLoaderInterface
{
    public function load(ServerRequestInterface $request);

    public function createStyleTag(string $style): string;

    public static function registerStyle(StyleInterface $style);

    public static function enqueueStyle(StyleInterface $style);
}
