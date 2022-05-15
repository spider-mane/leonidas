<?php

namespace Leonidas\Library\Admin\Component\Metabox\View;

use Leonidas\Contracts\Admin\Component\MetaboxComponentInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use WebTheory\Html\Traits\ElementConstructorTrait;

class MetaboxLayoutView implements ViewInterface
{
    use ElementConstructorTrait;

    public function render(array $context = []): string
    {
        /** @var MetaboxComponentInterface[] $components */
        $components = $context['components'];
        $separator = $context['separator'];
        $request = $context['request'];

        $html = '';
        $html .= $context['auth_field'];
        $html .= $this->open('div', ['class' => 'leonidas-wrap']);

        $count = count($components);

        foreach ($components as $component) {
            $count--;

            if ($component->shouldBeRendered($request)) {
                $html .= $component->renderComponent($request);

                if ($count > 0) {
                    $html .= $separator;
                }
            }
        }

        $html .= $this->close('div');

        return $html;
    }
}
