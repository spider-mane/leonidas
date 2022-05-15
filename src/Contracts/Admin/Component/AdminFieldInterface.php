<?php

namespace Leonidas\Contracts\Admin\Component;

use Psr\Http\Message\ServerRequestInterface;

interface AdminFieldInterface extends AdminComponentInterface
{
    public function getLabel(): string;

    public function getDescription(): string;

    public function renderInputField(ServerRequestInterface $request): string;
}
