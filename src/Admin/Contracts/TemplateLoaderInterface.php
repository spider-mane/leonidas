<?php

namespace WebTheory\Leonidas\Admin\Contracts;

interface TemplateLoaderInterface
{
    /**
     *
     */
    public function renderTemplate(array $context): string;
}
