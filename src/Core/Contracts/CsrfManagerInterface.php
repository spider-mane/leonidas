<?php

namespace WebTheory\Leonidas\Core\Contracts;

use Psr\Http\Message\ServerRequestInterface;

interface CsrfManagerInterface
{
    /**
     * Return unique tag for the manager
     */
    public function getTag(): string;

    /**
     * Validate a csrf token
     */
    public function validate(ServerRequestInterface $request): bool;

    /**
     * Render a csrf token form field
     */
    public function renderField(): string;
}
