<?php

namespace WebTheory\Leonidas\Contracts\Auth;

use Psr\Http\Message\ServerRequestInterface;

interface CsrfManagerInterface
{
    /**
     * Validate a csrf token
     */
    public function validate(ServerRequestInterface $request): bool;

    /**
     * Render a csrf token form field
     */
    public function renderField(): string;
}
