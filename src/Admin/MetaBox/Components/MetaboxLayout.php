<?php

namespace WebTheory\Leonidas\Admin\Metabox\Components;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\Contracts\MetaboxComponentInterface;
use WebTheory\Leonidas\Admin\Contracts\MetaboxLayoutInterface;
use WebTheory\Leonidas\Admin\Contracts\ViewInterface;
use WebTheory\Leonidas\Admin\Metabox\Views\MetaboxLayoutView;
use WebTheory\Leonidas\Admin\Traits\CanBeRestrictedTrait;
use WebTheory\Leonidas\Admin\Traits\RendersWithViewTrait;
use WebTheory\Leonidas\Core\Traits\HasNonceTrait;

class MetaboxLayout implements MetaboxLayoutInterface
{
    use CanBeRestrictedTrait;
    use HasNonceTrait;
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
            'auth_field' => $this->maybeRenderNonce(),
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
