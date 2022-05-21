<?php

namespace Leonidas\Library\Admin\Component\Metabox\View;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxComponentInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use WebTheory\Html\Traits\ElementConstructorTrait;

class MetaboxLayoutView implements ViewInterface
{
    use ElementConstructorTrait;

    public function render(array $data = []): string
    {
        /** @var MetaboxComponentInterface[] $components */
        $components = $data['components'];
        $separator = $data['separator'];
        $request = $data['request'];

        $html = '';
        $html .= $data['auth_field'];
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
