<?php

namespace Leonidas\Contracts\Admin\Component\Capsule;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\Controller\FormSubmissionManagerInterface;

interface FormProcessingCapsuleInterface
{
    public function processor(ServerRequestInterface $request): FormSubmissionManagerInterface;
}
