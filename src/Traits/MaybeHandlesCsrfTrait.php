<?php

namespace Leonidas\Traits;

use Leonidas\Contracts\Auth\CsrfManagerInterface;

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
     * @param CsrfManagerInterface $csrfTokenManager
     *
     * @return self
     */
    public function setTokenManager(CsrfManagerInterface $csrfTokenManager)
    {
        $this->csrfManager = $csrfTokenManager;

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
