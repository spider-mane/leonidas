<?php

namespace WebTheory\Leonidas\Core\Traits;

use WebTheory\Leonidas\Core\Contracts\CsrfManagerInterface;

trait MaybeHandlesCsrfTrait
{
    /**
     * @var CsrfManagerInterface
     */
    protected $csrfManager;

    /**
     * Get the value of csrfToken
     *
     * @return CsrfManagerInterface
     */
    public function getTokenManager(): CsrfManagerInterface
    {
        return $this->csrfManager;
    }

    /**
     * Set the value of csrfToken
     *
     * @param CsrfManagerInterface $csrfToken
     *
     * @return self
     */
    public function setTokenManager(CsrfManagerInterface $csrfToken)
    {
        $this->csrfManager = $csrfToken;

        return $this;
    }

    /**
     *
     */
    protected function renderTokenField(): string
    {
        return $this->csrfManager->renderField() . "\n";
    }

    /**
     *
     */
    protected function maybeRenderTokenField(): string
    {
        return isset($this->csrfManager) ? $this->renderTokenField() : '';
    }
}
