<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Library\Core\Asset\Traits\HasAssetDataTrait;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

abstract class AbstractAssetBuilder
{
    use HasAssetDataTrait;

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
    protected $dependencies;

    /**
     * @var string|bool|null
     */
    protected $version;

    /**
     * @var bool
     */
    protected $shouldBeEnqueued = false;

    /**
     * @var null|ServerRequestPolicyInterface
     */
    protected $policy;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var null|string
     */
    protected $crossorigin;

    public function __construct(string $handle)
    {
        $this->handle = $handle;
    }

    /**
     * Set the value of handle
     *
     * @param string $handle
     *
     * @return self
     */
    public function handle(string $handle)
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
    public function src($src)
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
    public function dependencies(string ...$dependencies)
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
    public function version($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Set the value of policy
     *
     * @param ServerRequestPolicyInterface $policy
     *
     * @return self
     */
    public function policy(?ServerRequestPolicyInterface $policy)
    {
        $this->policy = $policy;

        return $this;
    }

    /**
     * Set the value of attributes
     *
     * @param array|null $attributes
     *
     * @return self
     */
    public function attributes(?array $attributes)
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
    public function crossorigin(?string $crossorigin)
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
    public function enqueue(bool $shouldBeEnqueued): AbstractAssetBuilder
    {
        $this->shouldBeEnqueued = $shouldBeEnqueued;

        return $this;
    }
}
