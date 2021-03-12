<?php

namespace Leonidas\Library\Admin\Metabox\Components;

use Psr\Http\Message\ServerRequestInterface;
use Leonidas\Contracts\Admin\Components\MetaboxComponentInterface;
use Leonidas\Contracts\Admin\Components\MetaboxLayoutInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Metabox\Views\MetaboxLayoutView;
use Leonidas\Traits\CanBeRestrictedTrait;
use Leonidas\Traits\RendersWithViewTrait;
use Leonidas\Traits\MaybeHandlesCsrfTrait;

class MetaboxLayout implements MetaboxLayoutInterface
{
    use CanBeRestrictedTrait;
    use MaybeHandlesCsrfTrait;
    use RendersWithViewTrait;

    /**
     * Collection of components that fill the layout
     *
     * @var MetaboxComponentInterface[]
     */
    protected $components = [];

    /**
     *
     */
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

    /**
     *
     */
    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        return new MetaboxLayoutView();
    }

    /**
     *
     */
    protected function defineViewContext(ServerRequestInterface $request): array
    {
        return [
            'components' => $this->getComponents(),
            'auth_field' => $this->maybeRenderTokenField(),
            'separator' => $this->getComponentSeparator(),
            'request' => $request
        ];
    }

    /**
     *
     */
    protected function getComponentSeparator()
    {
        return '<hr>';
    }
}
