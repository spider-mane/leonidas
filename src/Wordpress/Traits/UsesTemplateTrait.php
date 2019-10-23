<?php

namespace Backalley\WordPress\Traits;

use Backalley\WordPress\Backalley;

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
