<?php

namespace Leonidas\Plugin\Functions\Config;

use Leonidas\Plugin\Leonidas;
use WebTheory\Config\Deferred\Callback;

use function WebTheory\Config\call;

/**
 * @internal
 */
function info(string $header): Callback
{
    return call(Leonidas::instance()->header(...), $header);
}

/**
 * @internal
 */
function path(?string $file = null): Callback
{
    return call(Leonidas::instance()->path(...), $file);
}

/**
 * @internal
 */
function abspath(?string $file = null): Callback
{
    return call(Leonidas::instance()->absPath(...), $file);
}

/**
 * @internal
 */
function url(?string $file = null): Callback
{
    return call(Leonidas::instance()->url(...), $file);
}
