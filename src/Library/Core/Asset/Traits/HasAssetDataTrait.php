<?php

namespace Leonidas\Library\Core\Asset\Traits;

use Leonidas\Contracts\Http\ConstrainerInterface;

trait HasAssetDataTrait
{
    /**
     * Get the value of handle
     *
     * @return string
     */
    public function getHandle(): string
    {
        return $this->handle;
    }

    /**
     * Get the value of src
     *
     * @return string|bool
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Get the value of deps
     *
     * @return string[]
     */
    public function getDependencies(): ?array
    {
        return $this->dependencies;
    }

    /**
     * Get the value of version
     *
     * @return string|bool|null
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the value of globalConstraints
     *
     * @return ConstrainerInterface[]
     */
    public function getGlobalConstraints(): array
    {
        return $this->globalConstraints;
    }

    /**
     * Get the value of registrationConstraints
     *
     * @return ConstrainerInterface[]
     */
    public function getRegistrationConstraints(): array
    {
        return $this->registrationConstraints;
    }

    /**
     * Get the value of enqueueConstraints
     *
     * @return ConstrainerInterface[]
     */
    public function getEnqueueConstraints(): array
    {
        return $this->enqueueConstraints;
    }

    /**
     * Get the value of attributes
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Get the value of crossorigin
     *
     * @return string
     */
    public function getCrossorigin(): ?string
    {
        return $this->crossorigin;
    }
}
