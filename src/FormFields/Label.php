<?php

namespace Backalley\FormFields;

use Backalley\Html\AbstractHtmlElementConstructor;


class Label extends AbstractHtmlElementConstructor
{
    /**
     *
     */
    protected $text = '';

    /**
     *
     */
    protected $for;

    /**
     *
     */
    public function __construct($text)
    {
        $this->text = $text;
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
        return $this->text;
    }

    /**
     *
     */
    public function __toString()
    {
        $html = '';

        $html .= $this->open('label', ['for' => $this->for]);
        $html .= $this->text;
        $html .= $this->close('label');

        return $html;
    }
}
