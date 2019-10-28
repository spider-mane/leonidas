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
        $template = "{$this->template}.twig";

        return Leonidas::get('container')->get('twig')->render($template, $context);
    }
}
