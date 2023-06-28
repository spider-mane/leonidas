<?php

namespace Leonidas\Contracts\Admin\Component\Metabox;

use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

interface MetaboxCapsuleInterface
{
    public function layout(MetaboxInterface $metabox): MetaboxLayoutInterface;

    public function policy(MetaboxInterface $metabox): ?ServerRequestPolicyInterface;
}
