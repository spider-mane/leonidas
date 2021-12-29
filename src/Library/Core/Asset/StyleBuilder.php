<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\StyleInterface;
use Leonidas\Library\Core\Asset\Traits\HasStyleDataTrait;

class StyleBuilder extends AbstractAssetBuilder
{
    use HasStyleDataTrait;

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

    /**
     * Set the value of media
     *
     * @param string $media
     *
     * @return self
     */
    public function media(?string $media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Set the value of isDisabled
     *
     * @param bool $isDisabled
     *
     * @return self
     */
    public function disabled(?bool $isDisabled)
    {
        $this->isDisabled = $isDisabled;

        return $this;
    }

    /**
     * Set the value of hrefLang
     *
     * @param string $hrefLang
     *
     * @return self
     */
    public function hreflang(?string $hrefLang)
    {
        $this->hrefLang = $hrefLang;

        return $this;
    }

    /**
     * Set the value of title
     *
     * @param string $title
     *
     * @return self
     */
    public function title(?string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function done(): StyleInterface
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

    public static function for(string $handle): StyleBuilder
    {
        return new static($handle);
    }

    public static function inlineFoundation(string $handle): StyleInterface
    {
        return static::for($handle)
            ->src(false)
            ->enqueue(true)
            ->done();
    }
}
