<?php

namespace Leonidas\Library\Admin\Component\Metabox;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxCapsuleInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxLayoutInterface;
use Leonidas\Library\Admin\Component\Metabox\Layout\SegmentedLayout;
use Leonidas\Library\Core\Http\Policy\NoPolicy;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class EmptyMetaboxCapsule implements MetaboxCapsuleInterface
{
    public function layout(MetaboxInterface $metabox): MetaboxLayoutInterface
    {
        return new SegmentedLayout();
    }

    public function policy(MetaboxInterface $metabox): ?ServerRequestPolicyInterface
    {
        return new NoPolicy();
    }
}
