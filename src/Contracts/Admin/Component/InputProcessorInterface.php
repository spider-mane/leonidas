<?php

namespace Leonidas\Contracts\Admin\Component;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\Report\ProcessedFormReportInterface;

interface InputProcessorInterface
{
    public function processInput(ServerRequestInterface $request): ?ProcessedFormReportInterface;
}
