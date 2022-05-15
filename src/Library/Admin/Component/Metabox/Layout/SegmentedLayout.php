<?php

namespace Leonidas\Library\Admin\Component\Metabox\Layout;

use Leonidas\Contracts\Admin\Component\MetaboxComponentInterface;
use Leonidas\Contracts\Admin\Component\MetaboxLayoutInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Admin\Abstracts\MaybeHandlesCsrfTrait;
use Leonidas\Library\Admin\Abstracts\RendersWithViewTrait;
use Leonidas\Library\Admin\Component\Metabox\View\MetaboxLayoutView;
use Psr\Http\Message\ServerRequestInterface;

class SegmentedLayout implements MetaboxLayoutInterface
{
    use CanBeRestrictedTrait;
    use MaybeHandlesCsrfTrait;
    use RendersWithViewTrait;

    /**
     * Collection of components that fill the layout
     *
     * @var MetaboxComponentInterface[]
     */
    protected array $components = [];

    protected string $separator = '<hr>';

    public function __construct(MetaboxComponentInterface ...$components)
    {
        $this->components = $components;
    }

    /**
     * Get components
     *
     * @return MetaboxComponentInterface[]
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * Add components
     *
     * @param MetaboxComponentInterface[] $components
     */
    public function addComponents(array $components)
    {
        foreach ($components as $component) {
            $this->addComponent($component);
        }

        return $this;
    }

    /**
     * Add single component
     *
     * @param MetaboxComponentInterface $component
     */
    public function addComponent(MetaboxComponentInterface $component)
    {
        $this->components[] = $component;

        return $this;
    }

    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        return new MetaboxLayoutView();
    }

    protected function defineViewContext(ServerRequestInterface $request): array
    {
        return [
            'components' => $this->getComponents(),
            'auth_field' => $this->maybeRenderTokenField(),
            'separator' => $this->getComponentSeparator(),
            'request' => $request,
        ];
    }

    protected function getComponentSeparator()
    {
        return $this->separator;
    }
}
