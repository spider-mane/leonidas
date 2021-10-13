<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Http\ConstrainerInterface;
use Leonidas\Contracts\Ui\Asset\AssetInterface;
use Leonidas\Library\Core\Asset\Traits\HasAssetDataTrait;
use Leonidas\Library\Core\Http\ConstrainerCollection;
use Psr\Http\Message\ServerRequestInterface;

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
     * @var array
     */
    protected $attributes = [];

    /**
     * @var null|string
     */
    public $crossorigin;

    /**
     * @var ConstrainerInterface[]
     */
    protected $globalConstraints = [];

    /**
     * @var ConstrainerInterface[]
     */
    protected $registrationConstraints = [];

    /**
     * @var ConstrainerInterface[]
     */
    protected $enqueueConstraints = [];

    public function __construct(
        string $handle,
        string $src,
        ?array $dependencies = null,
        $version = null,
        ?array $globalConstraints = null,
        ?array $registrationConstraints = null,
        ?array $enqueueConstraints = null,
        ?array $attributes = null,
        ?string $crossorigin = null
    ) {
        $this->handle = $handle;
        $this->src = $src;

        $dependencies && $this->dependencies = $dependencies;
        $version && $this->version = $version;
        $globalConstraints && $this->globalConstraints = $globalConstraints;
        $registrationConstraints && $this->registrationConstraints = $registrationConstraints;
        $enqueueConstraints && $this->enqueueConstraints = $enqueueConstraints;
        $attributes && $this->attributes = $attributes;
        $crossorigin && $this->crossorigin = $crossorigin;
    }

    public function shouldBeRegistered(ServerRequestInterface $request): bool
    {
        $collection = new ConstrainerCollection(
            ...$this->getGlobalConstraints() + $this->getRegistrationConstraints()
        );

        return !$collection->constrains($request);
    }

    public function shouldBeEnqueued(ServerRequestInterface $request): bool
    {
        $collection = new ConstrainerCollection(
            ...$this->getGlobalConstraints() + $this->getEnqueueConstraints()
        );

        return !$collection->constrains($request);
    }

    public function getSrcAttribute()
    {
        return null !== $this->getVersion() ? "{$this->getSrc()}?ver={$this->getVersion()}" : $this->getSrc();
    }
}
