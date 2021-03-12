<?php

namespace Leonidas\Library\Admin\Metabox\Views;

use WebTheory\Html\Traits\ElementConstructorTrait;
use Leonidas\Contracts\Admin\Components\AdminComponentInterface;
use Leonidas\Contracts\Ui\ViewInterface;

class SectionView implements ViewInterface
{
    use ElementConstructorTrait;

    /**
     *
     */
    public function render(array $context = []): string
    {
        $title = $context['title'];
        $padding = $context['padding'];
        $isFieldset = $context['is_fieldset'];
        $request = $context['request'];

        /** @var AdminComponentInterface[] $components */
        $components = $context['components'];

        $html = '';

        $titleElement = $this->tag('h3', [], $title);
        $attributes = ['class' => "py-{$padding}"];
        $container = $isFieldset ? 'fieldset' : 'div';

        $html .= $this->open($container, $attributes);

        if ($this->isFieldset && false) {
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
