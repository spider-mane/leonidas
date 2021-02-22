<?php

namespace WebTheory\Leonidas\Admin\Traits;

use WebTheory\Leonidas\Admin\Contracts\ViewInterface;
use WebTheory\Leonidas\Admin\TwigTemplate;
use WebTheory\Leonidas\Leonidas;

trait UsesTwigView
{
    /**
     * @var ViewInterface
     */
    protected $view;

    /**
     *
     */
    protected function renderTemplate($context)
    {
        return $this->view->render($context);
    }

    /**
     *
     */
    protected function getDefaultView(): ViewInterface
    {
        return new TwigTemplate(
            $this->getTemplateToRender(),
            $this->getTwigEnvironment()
        );
    }

    /**
     *
     */
    protected function getTwigEnvironment()
    {
        return Leonidas::get('container')->get('twig');
    }

    /**
     *
     */
    abstract protected function getTemplateToRender(): string;
}
