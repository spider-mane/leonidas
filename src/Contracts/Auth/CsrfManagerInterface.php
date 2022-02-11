<?php

namespace Leonidas\Contracts\Auth;

use Psr\Http\Message\ServerRequestInterface;

interface CsrfManagerInterface
{
    public function getName(): string;

    public function getToken(): string;

    /**
     * Validate a csrf token
     */
    public function validate(ServerRequestInterface $request): bool;

    /**
     * Render a csrf token form field
     */
    public function renderField(): string;
}
