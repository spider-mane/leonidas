<?php

namespace Leonidas\Contracts\Ui\Asset;

use Psr\Http\Message\ServerRequestInterface;

interface StyleLoaderInterface
{
    public function load(ServerRequestInterface $request);

    public static function createStyleTag(StyleInterface $style): string;

    public static function mergeStyleTag(string $tag, StyleInterface $style): string;

    public static function registerStyle(StyleInterface $style);

    public static function enqueueStyle(StyleInterface $style);
}
