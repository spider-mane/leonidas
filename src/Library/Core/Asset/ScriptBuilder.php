<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\ScriptInterface;
use Leonidas\Library\Core\Asset\Traits\HasScriptDataTrait;
use Leonidas\Library\Core\Asset\Traits\SetsScriptDataTrait;

class ScriptBuilder extends AbstractAssetBuilder
{
    use HasScriptDataTrait;
    use SetsScriptDataTrait;

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
