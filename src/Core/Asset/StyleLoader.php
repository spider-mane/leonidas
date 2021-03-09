<?php

namespace WebTheory\Leonidas\Core\Asset;

use WebTheory\Leonidas\Contracts\Ui\StyleInterface;

class StyleLoader
{
    /**
     * @var \WebTheory\Leonidas\Contracts\Ui\StyleInterface[]
     */
    protected $styles = [];

    public function __construct(StyleInterface ...$styles)
    {
        $this->styles = $styles;
    }

    /**
     * @return StyleInterface[]
     */
    protected function getStyles(): array
    {
        return $this->styles;
    }

    public function enqueue(): void
    {
        foreach ($this->getStyles() as $style) {
            wp_enqueue_style(
                $style->getHandle(),
                $style->getSrc(),
                $style->getDeps(),
                $style->getVersion(),
                $style->getMedia()
            );
        }
    }

    public function register(): void
    {
        foreach ($this->getStyles() as $style) {
            wp_register_style(
                $style->getHandle(),
                $style->getSrc(),
                $style->getDeps(),
                $style->getVersion(),
                $style->getMedia()
            );
        }
    }
}
