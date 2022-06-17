<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\ScriptInterface;
use Leonidas\Library\Core\Asset\Abstracts\HasScriptDataTrait;

class ScriptBuilder extends AbstractAssetBuilder
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

    /**
     * @return $this
     */
    public function inFooter(?bool $shouldLoadInFooter): ScriptBuilder
    {
        $this->shouldLoadInFooter = $shouldLoadInFooter;

        return $this;
    }

    /**
     * @return $this
     */
    public function async(bool $isAsync): ScriptBuilder
    {
        $this->isAsync = $isAsync;

        return $this;
    }

    /**
     * @return $this
     */
    public function deferred(bool $isDeferred): ScriptBuilder
    {
        $this->isDeferred = $isDeferred;

        return $this;
    }

    /**
     * @return $this
     */
    public function integrity(string $integrity): ScriptBuilder
    {
        $this->integrity = $integrity;

        return $this;
    }

    /**
     * @return $this
     */
    public function nomodule(bool $isNoModule): ScriptBuilder
    {
        $this->isNoModule = $isNoModule;

        return $this;
    }

    /**
     * @return $this
     */
    public function nonce(string $nonce): ScriptBuilder
    {
        $this->nonce = $nonce;

        return $this;
    }

    /**
     * @return $this
     */
    public function referrerpolicy(string $referrerPolicy): ScriptBuilder
    {
        $this->referrerPolicy = $referrerPolicy;

        return $this;
    }

    /**
     * @return $this
     */
    public function type(string $type): ScriptBuilder
    {
        $this->type = $type;

        return $this;
    }

    public function done(): ScriptInterface
    {
        return new Script(
            $this->getHandle(),
            $this->getSrc(),
            $this->getDependencies(),
            $this->getVersion(),
            $this->shouldLoadInFooter(),
            $this->shouldBeEnqueued(),
            $this->getPolicy(),
            $this->getAttributes(),
            $this->isAsync(),
            $this->getCrossorigin(),
            $this->isDeferred(),
            $this->getIntegrity(),
            $this->isNoModule(),
            $this->getNonce(),
            $this->getReferrerPolicy(),
            $this->getType()
        );
    }

    public static function for(string $handle): ScriptBuilder
    {
        return new static($handle);
    }

    public static function inlineFoundationInHeader(string $handle): ScriptInterface
    {
        return static::for($handle)
            ->src(false)
            ->enqueue(true)
            ->inFooter(false)
            ->done();
    }

    public static function inlineFoundationInFooter(string $handle): ScriptInterface
    {
        return static::for($handle)
            ->src(false)
            ->enqueue(true)
            ->inFooter(true)
            ->done();
    }
}
