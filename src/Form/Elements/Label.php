<?php

namespace Backalley\Form\Elements;

use Backalley\Html\AbstractHtmlElement;

class Label extends AbstractHtmlElement
{
    /**
     * @var string
     */
    protected $innerText;

    /**
     * @var string
     */
    protected $for;

    /**
     *
     */
    public function __construct(string $label)
    {
        $this->innerText = $label;
        parent::__construct();
    }

    /**
     * Get the value of for
     *
     * @return mixed
     */
    public function getFor()
    {
        return $this->for;
    }

    /**
     * Set the value of for
     *
     * @param mixed $for
     *
     * @return self
     */
    public function setFor($for)
    {
        $this->for = $for;

        return $this;
    }

    /**
     * Get the value of text
     *
     * @return mixed
     */
    public function getText()
    {
        return $this->innerText;
    }

    /**
     *
     */
    public function toHtml(): string
    {
        $html = '';

        $html .= $this->open('label', ['for' => $this->for]);
        $html .= $this->innerText;
        $html .= $this->close('label');

        return $html;
    }
}
