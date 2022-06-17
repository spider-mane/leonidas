<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Library\Core\Asset\Abstracts\HasAssetDataTrait;
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
    protected $dependencies = [];

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
     * @return $this
     */
    public function handle(string $handle): AbstractAssetBuilder
    {
        $this->handle = $handle;

        return $this;
    }

    /**
     * Set the value of src
     *
     * @param string|bool $src
     *
     * @return $this
     */
    public function src($src): AbstractAssetBuilder
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Set the value of dependencies
     *
     * @param string ...$dependencies
     *
     * @return $this
     */
    public function dependencies(string ...$dependencies): AbstractAssetBuilder
    {
        $this->dependencies = $dependencies;

        return $this;
    }

    /**
     * Set the value of version
     *
     * @param string|bool|null $version
     *
     * @return $this
     */
    public function version($version): AbstractAssetBuilder
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Set the value of policy
     *
     * @param ServerRequestPolicyInterface $policy
     *
     * @return $this
     */
    public function policy(?ServerRequestPolicyInterface $policy): AbstractAssetBuilder
    {
        $this->policy = $policy;

        return $this;
    }

    /**
     * Set the value of attributes
     *
     * @param array|null $attributes
     *
     * @return $this
     */
    public function attributes(?array $attributes): AbstractAssetBuilder
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Set the value of crossorigin
     *
     * @param string $crossorigin
     *
     * @return $this
     */
    public function crossorigin(?string $crossorigin): AbstractAssetBuilder
    {
        $this->crossorigin = $crossorigin;

        return $this;
    }

    /**
     * Set the value of shouldBeEnqueued
     *
     * @param bool $shouldBeEnqueued
     *
     * @return $this
     */
    public function enqueue(bool $shouldBeEnqueued): AbstractAssetBuilder
    {
        $this->shouldBeEnqueued = $shouldBeEnqueued;

        return $this;
    }
}
