<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleInterface;
use Psr\Http\Message\ServerRequestInterface;

class StyleLoader
{
    /**
     * @var StyleCollectionInterface
     */
    protected $styles;

    public function __construct(StyleCollectionInterface $styles)
    {
        $this->styles = $styles;
    }

    /**
     * @return StyleInterface[]
     */
    protected function getStyles(): array
    {
        return $this->styles->getStyles();
    }

    public function registerStyle(StyleInterface $style)
    {
        wp_register_style(
            $style->getHandle(),
            $style->getSrc(),
            $style->getDependencies(),
            $style->getVersion(),
            $style->getMedia()
        );
    }

    public function register(): void
    {
        foreach ($this->getStyles() as $style) {
            $this->registerStyle($style);
        }
    }

    public function registerIf(ServerRequestInterface $request)
    {
        foreach ($this->getStyles() as $style) {
            if ($style->shouldBeRegistered($request)) {
                $this->registerStyle($style);
            }
        }
    }

    public function enqueueStyle(StyleInterface $style)
    {
        wp_enqueue_style(
            $style->getHandle(),
            $style->getSrc(),
            $style->getDependencies(),
            $style->getVersion(),
            $style->getMedia()
        );
    }

    public function enqueue(): void
    {
        foreach ($this->getStyles() as $style) {
            $this->enqueueStyle($style);
        }
    }

    public function enqueueIf(ServerRequestInterface $request)
    {
        foreach ($this->getStyles() as $style) {
            if ($style->shouldBeRegistered($request)) {
                $this->enqueueStyle($style);
            }
        }
    }

    public function createStyleTag(string $style)
    {
        return $this->styles->getStyle($style)->toHtml();
    }
}
