<?php

namespace Example\Content\Metaboxes;

use Leonidas\Content\Elements\CopyInputRow;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxComponentInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxFieldInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxLayoutInterface;
use Leonidas\Framework\Capsule\Abstracts\MetaboxCapsule;
use Leonidas\Library\Admin\Component\Metabox\Element\Field;
use Leonidas\Library\Admin\Component\Metabox\Element\Section;
use Leonidas\Library\Admin\Component\Metabox\Layout\SegmentedLayout;
use Leonidas\Plugin\Module\Abstracts\LeonidasServices;
use Psr\Http\Message\ServerRequestInterface;
use WP_Screen;
use WebTheory\Saveyour\Contracts\Field\FormFieldInterface;

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
        return (new SegmentedLayout(...$this->components($request)))
            ->setSortable(true)
            ->setRepeatable(true);
    }

    /**
     * @return list<MetaboxComponentInterface>
     */
    protected function components(ServerRequestInterface $request): array
    {
        return [
            $this->introSegment($request),
            $this->detailsSegment($request),
            $this->summarySegment($request)
        ];
    }

    protected function introSegment(ServerRequestInterface $request): MetaboxComponentInterface
    {
        return (new Section('Introduction'));
    }

    protected function detailsSegment(ServerRequestInterface $request): MetaboxComponentInterface
    {
        return new Section('Details');
    }

    protected function summarySegment(ServerRequestInterface $request): MetaboxComponentInterface
    {
        return new Section('Summary');
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
