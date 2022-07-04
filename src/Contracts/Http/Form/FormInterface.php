<?php

namespace Leonidas\Contracts\Http\Form;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\Report\ValidationReportInterface;

interface FormInterface
{
    public function getHandle(): string;

    public function getAction(): string;

    public function onPriv(): bool;

    public function onNopriv(): bool;

    public function build(ServerRequestInterface $request): array;

    public function process(ServerRequestInterface $request): void;

    public function validate(ServerRequestInterface $request, string $field, $value): ValidationReportInterface;
}
