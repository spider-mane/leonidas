<?php

namespace Leonidas\Library\Core\Asset\Traits;

trait SetsStyleDataTrait
{
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
}
