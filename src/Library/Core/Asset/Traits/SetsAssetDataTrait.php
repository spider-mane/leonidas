<?php

namespace Leonidas\Library\Core\Asset\Traits;

use Leonidas\Contracts\Http\ConstrainerInterface;

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
     * @param string[] $dependencies
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
     * Set the value of globalConstraints
     *
     * @param array $globalConstraints
     *
     * @return self
     */
    public function setGlobalConstraints(ConstrainerInterface ...$globalConstraints)
    {
        $this->globalConstraints = $globalConstraints;

        return $this;
    }

    /**
     * Set the value of registrationConstraints
     *
     * @param array $registrationConstraints
     *
     * @return self
     */
    public function setRegistrationConstraints(ConstrainerInterface ...$registrationConstraints)
    {
        $this->registrationConstraints = $registrationConstraints;

        return $this;
    }

    /**
     * Set the value of enqueueConstraints
     *
     * @param array $enqueueConstraints
     *
     * @return self
     */
    public function setEnqueueConstraints(ConstrainerInterface ...$enqueueConstraints)
    {
        $this->enqueueConstraints = $enqueueConstraints;

        return $this;
    }

    /**
     * Set the value of attributes
     *
     * @param array $attributes
     *
     * @return self
     */
    public function setAttributes(array $attributes)
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
}
