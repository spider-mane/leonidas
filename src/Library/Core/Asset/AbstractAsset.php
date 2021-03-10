<?php

namespace WebTheory\Leonidas\Library\Core\Asset;

use WebTheory\Leonidas\Contracts\Ui\AssetInterface;

abstract class AbstractAsset implements AssetInterface
{
    /**
     * @var string
     */
    protected $handle;

    /**
     * @var string|bool
     */
    protected $src;

    /**
     * @var string[]
     */
    protected $deps;

    /**
     * @var string|bool|null
     */
    protected $version;

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
     * Get the value of src
     *
     * @return string|bool
     */
    public function getSrc()
    {
        return $this->src;
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
     * Get the value of deps
     *
     * @return string[]
     */
    public function getDeps(): ?array
    {
        return $this->deps;
    }

    /**
     * Set the value of deps
     *
     * @param string[] $deps
     *
     * @return self
     */
    public function setDeps(?array $deps)
    {
        $this->deps = $deps;

        return $this;
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
}
