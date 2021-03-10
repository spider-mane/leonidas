<?php

namespace WebTheory\Leonidas\Library\Core\Asset;

use WebTheory\Leonidas\Contracts\Ui\StyleInterface;

class Style extends AbstractAsset implements StyleInterface
{
    /**
     * @var string
     */
    protected $media;

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
     * Set the value of media
     *
     * @param string $media
     *
     * @return self
     */
    public function setMedia(?string $media)
    {
        $this->media = $media;

        return $this;
    }
}
