<?php

namespace WebTheory\WordPress\Traits;

use WebTheory\WordPress\Backalley;

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
