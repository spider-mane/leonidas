<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\InlineStyleCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleInterface;
use Leonidas\Contracts\Ui\Asset\StyleLoaderInterface;
use Psr\Http\Message\ServerRequestInterface;

class StyleLoader implements StyleLoaderInterface
{
    public function load(StyleCollectionInterface $styles, ServerRequestInterface $request)
    {
        foreach ($styles->getStyles() as $style) {
            if ($style->shouldBeLoaded($request)) {
                if ($style->shouldBeEnqueued()) {
                    $this->enqueueStyle($style);
                } else {
                    $this->registerStyle($style);
                }
            }
        }
    }

    public function support(InlineStyleCollectionInterface $styles, ServerRequestInterface $request)
    {
        foreach ($styles->getStyles() as $style) {
            if ($style->shouldBeLoaded($request)) {
                $this->addInlineStyle($style);
            }
        }
    }

    public function activate(string ...$styles)
    {
        foreach ($styles as $style) {
            wp_enqueue_style($style);
        }
    }

    public function deactivate(string ...$styles)
    {
        foreach ($styles as $style) {
            wp_dequeue_style($style);
        }
    }

    protected function registerStyle(StyleInterface $style)
    {
        wp_register_style(
            $style->getHandle(),
            $style->getSrc(),
            $style->getDependencies(),
            $style->getVersion(),
            $style->getMedia()
        );

        // $this->loadStyleAddons($style);
    }

    protected function enqueueStyle(StyleInterface $style)
    {
        wp_enqueue_style(
            $style->getHandle(),
            $style->getSrc(),
            $style->getDependencies(),
            $style->getVersion(),
            $style->getMedia()
        );

        // $this->loadStyleAddons($style);
    }

    protected function addInlineStyle($style)
    {
        wp_add_inline_style(
            $style->getHandle(),
            $style->getData(),
            $style->getPosition()
        );
    }

    // protected function loadStyleAddons(StyleInterface $style)
    // {
    //     if ($style->hasInlineAfter()) {
    //         $this->addInlineStyle($style->getInlineAfter());
    //     }
    // }
}
