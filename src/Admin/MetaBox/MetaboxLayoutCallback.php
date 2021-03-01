<?php

namespace WebTheory\Leonidas\Admin\Metabox;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\AbstractAdminComponentCallback;
use WebTheory\Leonidas\Admin\Contracts\MetaboxLayoutInterface;
use WebTheory\Leonidas\Admin\Traits\CanBeRestrictedTrait;

class MetaboxLayoutCallback extends AbstractAdminComponentCallback implements MetaboxLayoutInterface
{
    use CanBeRestrictedTrait;
}
