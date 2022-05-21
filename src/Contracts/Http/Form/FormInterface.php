<?php

namespace Leonidas\Contracts\Http\Form;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\Report\ValidationReportInterface;

interface FormInterface extends FormHandlerInterface
{
    public function getAction(): string;

    public function onPriv(): bool;

    public function onNopriv(): bool;

    public function process(ServerRequestInterface $request): void;

    public function validate(ServerRequestInterface $request, string $field, $value): ValidationReportInterface;
}
