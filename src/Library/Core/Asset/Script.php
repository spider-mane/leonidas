<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\ScriptInterface;

class Script extends AbstractAsset implements ScriptInterface
{
    /**
     * @var bool
     */
    protected $loadInFooter;

    /**
     * Get the value of isInFooter
     *
     * @return bool
     */
    public function loadInFooter(): ?bool
    {
        return $this->loadInFooter;
    }

    /**
     * Set the value of isInFooter
     *
     * @param bool $isInFooter
     *
     * @return self
     */
    public function setLoadInFooter(?bool $isInFooter)
    {
        $this->loadInFooter = $isInFooter;

        return $this;
    }
}
