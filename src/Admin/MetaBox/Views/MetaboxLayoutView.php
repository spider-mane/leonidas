<?php

namespace WebTheory\Leonidas\Admin\Metabox\Views;

use WebTheory\Html\Traits\ElementConstructorTrait;
use WebTheory\Leonidas\Admin\Contracts\MetaboxComponentInterface;
use WebTheory\Leonidas\Admin\Contracts\ViewInterface;

class MetaboxLayoutView implements ViewInterface
{
    use ElementConstructorTrait;

    /**
     *
     */
    public function render(array $context = []): string
    {
        /** @var MetaboxComponentInterface[] $components */
        $components = $context['components'];
        $request = $context['request'];

        $html = '';
        $html .= $context['auth_field'];
        $html .= $this->open('div', ['class' => 'backalley-wrap']);

        $i = count($components);

        foreach ($components as $component) {
            $i--;

            if ($component->shouldBeRendered($request)) {

                $html .= $component->renderComponent($request);

                if ($i > 0) {
                    $html .= $context['separator'];
                }
            }
        }

        $html .= $this->close('div');

        return $html;
    }
}
