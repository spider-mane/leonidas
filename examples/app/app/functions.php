<?php

namespace Example\Plugin;

function plugin_header(string $header)
{
    return Plugin::instance()->header($header);
}

function path(?string $file = null): string
{
    return Plugin::instance()->path($file);
}

function abspath(?string $file = null): string
{
    return Plugin::instance()->absPath($file);
}

function url(?string $file = null): string
{
    return Plugin::instance()->url($file);
}
