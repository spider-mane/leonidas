<?php

namespace Leonidas\Plugin;

function plugin_header(string $header)
{
    return LEONIDAS_PLUGIN_HEADERS[$header];
}
