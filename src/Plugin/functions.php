<?php

namespace Leonidas\Plugin;

function plugin_header(string $header)
{
    return Leonidas::instance()->header($header);
}

function path(?string $file = null): string
{
    return Leonidas::instance()->path($file);
}

function abspath(?string $file = null): string
{
    return Leonidas::instance()->absPath($file);
}

function url(?string $file = null): string
{
    return Leonidas::instance()->url($file);
}
