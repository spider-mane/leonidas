<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\StyleInterface;
use Leonidas\Contracts\Ui\Asset\StylePrinterInterface;
use WebTheory\Html\Html;

class StylePrinter implements StylePrinterInterface
{
    public function print(StyleInterface $style): string
    {
        return Html::tag('link', [
            'rel' => 'stylesheet',
            'id' => $this->getIdAttribute($style),
            'href' => $this->getHrefAttribute($style),
            'media' => $style->getMedia(),
            'hreflang' => $style->getHrefLang(),
            'title' => $style->getTitle(),
            'disabled' => $style->isDisabled(),
            'crossorigin' => $style->getCrossorigin(),
        ] + $style->getAttributes()) . "\n";
    }

    public function merge(string $tag, StyleInterface $style): string
    {
        return $this->print($style);
    }

    protected function getIdAttribute(StyleInterface $style): string
    {
        return "{$style->getHandle()}-css";
    }

    public function getHrefAttribute(StyleInterface $style): string
    {
        return null !== $style->getVersion()
            ? "{$style->getSrc()}?ver={$style->getVersion()}"
            : $style->getSrc();
    }
}
