<?php

namespace WebTheory\Leonidas\Traits;

use WebTheory\Leonidas\Backalley;

trait UsesTemplateTrait
{
    /**
     *
     */
    protected function renderTemplate($context)
    {
        return Backalley::renderTemplate($this->template, $context);
    }
}
