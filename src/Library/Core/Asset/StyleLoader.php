<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleInterface;
use Leonidas\Contracts\Ui\Asset\StyleLoaderInterface;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Html\Html;

class StyleLoader implements StyleLoaderInterface
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
     * @return StyleCollectionInterface
     */
    protected function getStyles(): StyleCollectionInterface
    {
        return $this->styles;
    }

    public function load(ServerRequestInterface $request)
    {
        foreach ($this->getStyles()->getStyles() as $style) {
            if ($style->shouldBeEnqueued()) {
                if ($style->shouldBeLoaded($request)) {
                    $this->enqueueStyle($style);
                }
            } else {
                $this->registerStyle($style);
            }
        }
    }

    public static function registerStyle(StyleInterface $style)
    {
        wp_register_style(
            $style->getHandle(),
            $style->getSrc(),
            $style->getDependencies(),
            $style->getVersion(),
            $style->getMedia()
        );
    }

    public static function enqueueStyle(StyleInterface $style)
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

    public static function createStyleTag(StyleInterface $style): string
    {
        return Html::tag('link', [
            'rel' => 'stylesheet',
            'href' => static::getHrefAttribute($style),
            'id' => static::getIdAttribute($style),
            'media' => $style->getMedia(),
            'hreflang' => $style->getHrefLang(),
            'title' => $style->getTitle(),
            'disabled' => $style->isDisabled(),
            'crossorigin' => $style->getCrossorigin(),
        ] + $style->getAttributes()) . "\n";
    }

    public static function mergeStyleTag(string $tag, StyleInterface $style): string
    {
        return static::createStyleTag($style);
    }

    protected static function getIdAttribute(StyleInterface $style)
    {
        return "{$style->getHandle()}-js";
    }

    public static function getHrefAttribute(StyleInterface $style)
    {
        return null !== $style->getVersion()
            ? "{$style->getSrc()}?ver={$style->getVersion()}"
            : $style->getSrc();
    }
}
