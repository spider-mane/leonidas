<?php

namespace WebTheory\Leonidas\Contracts;

interface TemplateLoaderInterface
{
    /**
     *
     */
    public function renderTemplate(array $context): string;
}
