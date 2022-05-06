<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\AssetInterface;
use Leonidas\Library\Core\Asset\Traits\HasAssetDataTrait;
use Leonidas\Library\Core\Http\Policies\NoPolicy;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

abstract class AbstractAsset implements AssetInterface
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
     * @var string[]|null
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
    public $crossorigin;

    public function __construct(
        string $handle,
        string $src,
        ?array $dependencies = null,
        $version = null,
        ?bool $shouldBeEnqueued,
        ?ServerRequestPolicyInterface $policy = null,
        ?array $attributes = null,
        ?string $crossorigin = null
    ) {
        $this->handle = $handle;
        $this->src = $src;

        $dependencies && $this->dependencies = $dependencies;
        $version && $this->version = $version;
        $shouldBeEnqueued && $this->shouldBeEnqueued = $shouldBeEnqueued;
        $attributes && $this->attributes = $attributes;
        $crossorigin && $this->crossorigin = $crossorigin;

        $this->policy = $policy ?? new NoPolicy();
    }

    public function shouldBeLoaded(ServerRequestInterface $request): bool
    {
        return $this->policy->approvesRequest($request);
    }

    public function getSrcAttribute()
    {
        return null !== $this->getVersion() ? "{$this->getSrc()}?ver={$this->getVersion()}" : $this->getSrc();
    }
}
