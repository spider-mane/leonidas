<?php

namespace WebTheory\Leonidas\Admin\Traits;

use Psr\Http\Message\ServerRequestInterface;

trait RendersWithTemplateTrait
{
    use UsesTemplateTrait;

    /**
     *
     */
    public function renderComponent(ServerRequestInterface $request): string
    {
        return $this->renderTemplate($this->defineTemplateContext($request));
    }

    /**
     *
     */
    abstract protected function defineTemplateContext(ServerRequestInterface $request): array;
}
