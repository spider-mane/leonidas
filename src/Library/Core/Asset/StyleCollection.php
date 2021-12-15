<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleInterface;

class StyleCollection implements StyleCollectionInterface
{
    /**
     * @var StyleInterface[]
     */
    protected $styles;

    public function __construct(StyleInterface ...$styles)
    {
        array_map([$this, 'addStyle'], $styles);
    }

    /**
     * Get the value of styles
     *
     * @return StyleInterface[]
     */
    public function getStyles(): array
    {
        return $this->styles;
    }

    public function addStyle(StyleInterface $style)
    {
        $this->styles[$style->getHandle()] = $style;
    }

    public function getStyle(string $style): StyleInterface
    {
        return $this->styles[$style];
    }

    public function hasStyle(string $style): bool
    {
        return isset($this->styles[$style]);
    }

    public static function with(StyleInterface ...$styles)
    {
        return new static(...$styles);
    }
}
