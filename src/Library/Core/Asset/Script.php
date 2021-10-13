<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\ScriptInterface;
use Leonidas\Library\Core\Asset\Traits\HasScriptDataTrait;
use WebTheory\Html\Html;

class Script extends AbstractAsset implements ScriptInterface
{
    use HasScriptDataTrait;

    /**
     * @var bool
     */
    protected $loadInFooter;

    /**
     * @var null|bool
     */
    public $isAsync;

    /**
     * @var null|bool
     */
    public $isDeferred;

    /**
     * @var null|string
     */
    public $integrity;

    /**
     * @var null|bool
     */
    public $isNoModule;

    /**
     * @var null|string
     */
    public $nonce;

    /**
     * @var null|string
     */
    public $referrerPolicy;

    /**
     * @var null|string
     */
    public $type;

    public function __construct(
        string $handle,
        string $src,
        ?array $dependencies,
        $version,
        ?bool $loadInFooter = null,
        ?array $globalConstraints = null,
        ?array $registrationConstraints = null,
        ?array $enqueueConstraints = null,
        ?array $attributes = null,
        ?bool $isAsync = null,
        ?string $crossorigin,
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
            $globalConstraints,
            $registrationConstraints,
            $enqueueConstraints,
            $attributes,
            $crossorigin
        );

        $loadInFooter && $this->loadInFooter = $loadInFooter;
        $isAsync && $this->isAsync = $isAsync;
        $isDeferred && $this->isDeferred = $isDeferred;
        $integrity && $this->integrity = $integrity;
        $isNoModule && $this->isNoModule = $isNoModule;
        $nonce && $this->nonce = $nonce;
        $referrerPolicy && $this->referrerPolicy = $referrerPolicy;
        $type && $this->type = $type;
    }

    public function toHtml(): string
    {
        return Html::tag('script', [
            'src' => $this->getSrcAttribute(),
            'id' => "{$this->getHandle()}-js",
            'async' => $this->isAsync(),
            'crossorigin' => $this->getCrossorigin(),
            'defer' => $this->isDeferred(),
            'integrity' => $this->getIntegrity(),
            'nomodule' => $this->isNoModule(),
            'nonce' => $this->getNonce(),
            'rererrerpolicy' => $this->getReferrerPolicy(),
            'type' => $this->getType()
        ] + $this->getAttributes()) . "\n";
    }
}
