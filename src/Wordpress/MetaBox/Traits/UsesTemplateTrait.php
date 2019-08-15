<?php

namespace Backalley\Wordpress\MetaBox\Traits;

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
