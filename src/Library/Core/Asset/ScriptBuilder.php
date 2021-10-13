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

    public function create(): ScriptInterface
    {
        return new Script(
            $this->getHandle(),
            $this->getSrc(),
            $this->getDependencies(),
            $this->getVersion(),
            $this->loadInFooter(),
            $this->getGlobalConstraints(),
            $this->getRegistrationConstraints(),
            $this->getEnqueueConstraints(),
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

    public static function start(string $handle): ScriptBuilder
    {
        return new static($handle);
    }
}
