<?php

namespace Example\Content\Metaboxes;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxLayoutInterface;
use Leonidas\Framework\Capsule\Abstracts\MetaboxCapsule;
use Leonidas\Library\Admin\Component\Metabox\Layout\SegmentedLayout;
use Leonidas\Plugin\Module\Abstracts\LeonidasServices;
use Psr\Http\Message\ServerRequestInterface;
use WP_Screen;

class SectionMetabox extends MetaboxCapsule
{
    use LeonidasServices;

    public function id(): string
    {
        return $this->slug('section');
    }

    public function title(): string
    {
        return 'Section';
    }

    public function screen(): string|array|WP_Screen
    {
        return $this->key('section');
    }

    public function layout(ServerRequestInterface $request): MetaboxLayoutInterface
    {
        return new SegmentedLayout(
            //
        );
    }

    protected function formFields(ServerRequestInterface $request): array
    {
        return [
            //
        ];
    }

    protected function alerts(): array
    {
        return [
            //
        ];
    }
}
