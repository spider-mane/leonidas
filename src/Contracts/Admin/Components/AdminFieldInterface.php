<?php

namespace Leonidas\Contracts\Admin\Components;

use Leonidas\Contracts\Admin\Components\AdminComponentInterface;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;

interface AdminFieldInterface extends AdminComponentInterface
{
    public function getLabel(): string;

    public function getDescription(): string;

    public function renderInputField(ServerRequestInterface $request): string;
}
