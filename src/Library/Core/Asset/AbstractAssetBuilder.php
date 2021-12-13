<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;
use Leonidas\Library\Core\Asset\Traits\HasAssetDataTrait;
use Leonidas\Library\Core\Asset\Traits\SetsAssetDataTrait;

abstract class AbstractAssetBuilder
{
    use HasAssetDataTrait;
    use SetsAssetDataTrait;

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
     * @var ConstrainerCollectionInterface
     */
    protected $constraints;

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
}
