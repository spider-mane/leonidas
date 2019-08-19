<?php

namespace Backalley\Wordpress\Traits;

use Timber\Timber;

trait UsesTemplateTrait
{
    /**
     *
     */
    protected function renderTemplate($context)
    {
        return Timber::compile("{$this->template}.twig", $context);
    }
}
