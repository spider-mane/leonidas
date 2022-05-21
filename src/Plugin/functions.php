<?php

namespace Leonidas\Plugin;

function header(string $header)
{
    return LEONIDAS_PLUGIN_HEADERS[$header];
}
