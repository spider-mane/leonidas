<?php

namespace Leonidas\Library\Admin\Component\Metabox\View;

use Leonidas\Contracts\Admin\Component\AdminComponentInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use WebTheory\Html\Traits\ElementConstructorTrait;

class SectionView implements ViewInterface
{
    use ElementConstructorTrait;

    public function render(array $data = []): string
    {
        $title = $data['title'];
        $padding = $data['padding'];
        $isFieldset = $data['is_fieldset'];
        $request = $data['request'];

        /** @var AdminComponentInterface[] $components */
        $components = $data['components'];

        $html = '';

        $titleElement = $this->tag('h3', [], $title);
        $attributes = ['class' => "py-{$padding}"];
        $container = $isFieldset ? 'fieldset' : 'div';

        $html .= $this->open($container, $attributes);

        if ($isFieldset && false) { // @phpstan-ignore-line
            // temporarily disabled because legend elements are absolutely
            // positioned within their container, making padding not work
            // as desired
            $html .= $this->tag('legend', [], $titleElement);
        } else {
            $html .= $titleElement;
        }

        foreach ($components as $component) {
            if ($component->shouldBeRendered($request)) {
                $html .= $component->renderComponent($request);
            }
        }

        $html .= $this->close($container);

        return $html;
    }
}
