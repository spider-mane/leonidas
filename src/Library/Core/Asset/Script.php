<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Http\ServerRequestPolicyInterface;
use Leonidas\Contracts\Ui\Asset\ScriptInterface;
use Leonidas\Library\Core\Asset\Traits\HasScriptDataTrait;

class Script extends AbstractAsset implements ScriptInterface
{
    use HasScriptDataTrait;

    /**
     * @var bool
     */
    protected $shouldLoadInFooter;

    /**
     * @var null|bool
     */
    protected $isAsync;

    /**
     * @var null|bool
     */
    protected $isDeferred;

    /**
     * @var null|string
     */
    protected $integrity;

    /**
     * @var null|bool
     */
    protected $isNoModule;

    /**
     * @var null|string
     */
    protected $nonce;

    /**
     * @var null|string
     */
    protected $referrerPolicy;

    /**
     * @var null|string
     */
    protected $type;

    public function __construct(
        string $handle,
        string $src,
        ?array $dependencies,
        $version = null,
        ?bool $shouldLoadInFooter = null,
        ?bool $shouldBeEnqueued = null,
        ?ServerRequestPolicyInterface $policy = null,
        ?array $attributes = null,
        ?bool $isAsync = null,
        ?string $crossorigin = null,
        ?bool $isDeferred = null,
        ?string $integrity = null,
        ?bool $isNoModule = null,
        ?string $nonce = null,
        ?string $referrerPolicy = null,
        ?string $type = null
    ) {
        parent::__construct(
            $handle,
            $src,
            $dependencies,
            $version,
            $shouldBeEnqueued,
            $policy,
            $attributes,
            $crossorigin
        );

        $shouldLoadInFooter && $this->shouldLoadInFooter = $shouldLoadInFooter;
        $isAsync && $this->isAsync = $isAsync;
        $isDeferred && $this->isDeferred = $isDeferred;
        $integrity && $this->integrity = $integrity;
        $isNoModule && $this->isNoModule = $isNoModule;
        $nonce && $this->nonce = $nonce;
        $referrerPolicy && $this->referrerPolicy = $referrerPolicy;
        $type && $this->type = $type;
    }
}
