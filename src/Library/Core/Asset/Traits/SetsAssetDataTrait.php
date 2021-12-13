<?php

namespace Leonidas\Library\Core\Asset\Traits;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;

trait SetsAssetDataTrait
{
    /**
     * Set the value of handle
     *
     * @param string $handle
     *
     * @return self
     */
    public function setHandle(string $handle)
    {
        $this->handle = $handle;

        return $this;
    }

    /**
     * Set the value of src
     *
     * @param string|bool $src
     *
     * @return self
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Set the value of dependencies
     *
     * @param string ...$dependencies
     *
     * @return self
     */
    public function setDependencies(string ...$dependencies)
    {
        $this->dependencies = $dependencies;

        return $this;
    }

    /**
     * Set the value of version
     *
     * @param string|bool|null $version
     *
     * @return self
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Set the value of constraints
     *
     * @param ConstrainerCollectionInterface $constraints
     *
     * @return self
     */
    public function setConstraints(ConstrainerCollectionInterface $constraints)
    {
        $this->constraints = $constraints;

        return $this;
    }

    /**
     * Set the value of attributes
     *
     * @param array|null $attributes
     *
     * @return self
     */
    public function setAttributes(?array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Set the value of crossorigin
     *
     * @param string $crossorigin
     *
     * @return self
     */
    public function setCrossorigin(?string $crossorigin)
    {
        $this->crossorigin = $crossorigin;

        return $this;
    }

    /**
     * Set the value of attributes
     *
     * @param bool $attributes
     *
     * @return self
     */
    public function setShouldBeEnqueued(bool $shouldBeEnqueued)
    {
        $this->shouldBeEnqueued = $shouldBeEnqueued;

        return $this;
    }
}
