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
        $template = $this->defineTemplate();

        return Leonidas::get('container')->get('twig')->render($template, $context);
    }

    /**
     *
     */
    protected function defineTemplate()
    {
        return "{$this->template}.twig";
    }
}
