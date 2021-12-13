<?php

namespace Leonidas\Library\Admin\Forms\Validators;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\FormValidatorInterface;

class NoAutosave implements FormValidatorInterface
{
    /**
     *
     */
    public function isValid(ServerRequestInterface $request): bool
    {
        return !(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE);
    }
}
