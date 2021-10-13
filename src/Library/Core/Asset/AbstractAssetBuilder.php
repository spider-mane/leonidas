<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Http\ConstrainerInterface;
use Leonidas\Contracts\Ui\Asset\AssetInterface;
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

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var null|string
     */
    public $crossorigin;

    public function __construct(string $handle)
    {
        $this->handle = $handle;
    }
}
