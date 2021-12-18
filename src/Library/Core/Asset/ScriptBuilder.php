<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\ScriptInterface;
use Leonidas\Contracts\Ui\Asset\ScriptLocalizationInterface;
use Leonidas\Library\Core\Asset\Traits\HasScriptDataTrait;
use Leonidas\Library\Core\Asset\Traits\SetsScriptDataTrait;

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

    protected ?ScriptLocalizationInterface $localization = null;

    protected ?array $localizationData = null;

    public function inFooter(?bool $shouldLoadInFooter)
    {
        $this->shouldLoadInFooter = $shouldLoadInFooter;

        return $this;
    }

    public function async(bool $isAsync)
    {
        $this->isAsync = $isAsync;

        return $this;
    }

    public function deferred(bool $isDeferred)
    {
        $this->isDeferred = $isDeferred;

        return $this;
    }

    public function integrity(string $integrity)
    {
        $this->integrity = $integrity;

        return $this;
    }

    public function nomodule(bool $isNoModule)
    {
        $this->isNoModule = $isNoModule;

        return $this;
    }

    public function nonce(string $nonce)
    {
        $this->nonce = $nonce;

        return $this;
    }

    public function referrerpolicy(string $referrerPolicy)
    {
        $this->referrerPolicy = $referrerPolicy;

        return $this;
    }

    public function type(string $type)
    {
        $this->type = $type;

        return $this;
    }

    public function localization(ScriptLocalizationInterface $localization)
    {
        $this->localization = $localization;
    }

    public function localizeWith(string $variable, array $data)
    {
        $this->localizationData = ['variable' => $variable, 'data' => $data];
    }

    public function getLocalizationData(): ?array
    {
        return $this->localizationData;
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
            $this->getConstraints(),
            $this->getLocalization() ?? $this->getLocalizationData(),
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
