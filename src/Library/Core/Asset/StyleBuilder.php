<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\StyleInterface;
use Leonidas\Library\Core\Asset\Traits\HasStyleDataTrait;
use Leonidas\Library\Core\Asset\Traits\SetsStyleDataTrait;

class StyleBuilder extends AbstractAssetBuilder
{
    use HasStyleDataTrait;
    use SetsStyleDataTrait;

    /**
     * @var string
     */
    protected $media = 'all';

    /**
     * @var bool
     */
    protected $isDisabled;

    /**
     * @var string
     */
    protected $hrefLang;

    /**
     * @var string
     */
    protected $title;

    public function build(): StyleInterface
    {
        return new Style(
            $this->getHandle(),
            $this->getSrc(),
            $this->getDependencies(),
            $this->getVersion(),
            $this->getMedia(),
            $this->shouldBeEnqueued(),
            $this->getConstraints(),
            $this->getAttributes(),
            $this->getCrossorigin(),
            $this->isDisabled(),
            $this->getHrefLang(),
            $this->getTitle()
        );
    }

    public static function prepare(string $handle): StyleBuilder
    {
        return new static($handle);
    }
}
