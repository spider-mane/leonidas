<?php

namespace WebTheory\Leonidas\Admin\MetaBox\Components;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Html\Html;
use WebTheory\Leonidas\Admin\Contracts\MetaboxComponentInterface;
use WebTheory\Leonidas\Admin\Contracts\MetaboxLayoutInterface;
use WebTheory\Leonidas\Admin\Traits\CanBeRestrictedTrait;
use WebTheory\Leonidas\Core\Traits\HasNonceTrait;

class MetaboxLayout implements MetaboxLayoutInterface
{
    use CanBeRestrictedTrait;
    use HasNonceTrait;

    /**
     * component
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
     * Get content
     *
     * @return MetaboxComponentInterface
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
     *
     */
    public function addComponent(MetaboxComponentInterface $component)
    {
        $this->components[] = $component;

        return $this;
    }

    /**
     *
     */
    public function renderComponent(ServerRequestInterface $request): string
    {
        $html = '';
        $html .= $this->maybeRenderNonce();
        $html .= Html::open('div', ['class' => 'backalley-wrap']);

        $i = count($this->components);

        foreach ($this->components as $component) {
            $i--;

            if ($component->shouldBeRendered($request)) {

                $html .= $component->renderComponent($request);

                if ($i > 0) {
                    $html .= $this->getSeparator();
                }
            }
        }

        $html .= Html::close('div');

        return $html;
    }

    /**
     *
     */
    protected function getSeparator()
    {
        return '<hr>';
    }
}
