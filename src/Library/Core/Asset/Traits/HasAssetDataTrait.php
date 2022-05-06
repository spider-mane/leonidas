<?php

namespace Leonidas\Library\Core\Asset\Traits;

use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

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
     * Get the value of shouldBeEnqueued
     *
     * @return bool
     */
    public function shouldBeEnqueued(): bool
    {
        return $this->shouldBeEnqueued;
    }

    /**
     * Get the value of globalPolicy
     *
     * @return ServerRequestPolicyInterface
     */
    public function getPolicy(): ?ServerRequestPolicyInterface
    {
        return $this->policy;
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
