<?php

namespace Leonidas\Library\Core\Asset\Abstracts;

trait HasStyleDataTrait
{
    /**
     * Get the value of media
     *
     * @return string
     */
    public function getMedia(): ?string
    {
        return $this->media;
    }

    /**
     * Get the value of isDisabled
     *
     * @return bool
     */
    public function isDisabled(): ?bool
    {
        return $this->isDisabled;
    }

    /**
     * Get the value of hrefLang
     *
     * @return string
     */
    public function getHrefLang(): ?string
    {
        return $this->hrefLang;
    }

    /**
     * Get the value of title
     *
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
}
