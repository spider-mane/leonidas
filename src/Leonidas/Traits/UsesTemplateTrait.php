<?php

namespace WebTheory\Leonidas\Traits;

use WebTheory\Leonidas\Leonidas;

trait UsesTemplateTrait
{
    /**
     *
     */
    protected function renderTemplate($context)
    {
        return Leonidas::renderTemplate($this->template, $context);
    }
}
