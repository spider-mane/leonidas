<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\InlineStyleCollectionInterface;
use Leonidas\Contracts\Ui\Asset\InlineStyleInterface;
use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleInterface;

class InlineStyleCollection implements InlineStyleCollectionInterface
{
    /**
     * @var InlineStyleInterface[]
     */
    protected array $styles = [];

    public function __construct(InlineStyleInterface ...$styles)
    {
        array_map([$this, 'addStyle'], $styles);
    }

    /**
     * Get the value of styles
     *
     * @return InlineStyleInterface[]
     */
    public function getStyles(): array
    {
        return $this->styles;
    }

    public function addStyle(InlineStyleInterface $style)
    {
        $this->styles[] = $style;
    }

    public function getStyle(string $style): InlineStyleInterface
    {
        return $this->styles[$style];
    }

    public function hasStyle(string $style): bool
    {
        return isset($this->styles[$style]);
    }

    public static function with(InlineStyleInterface ...$styles)
    {
        return new static(...$styles);
    }
}
