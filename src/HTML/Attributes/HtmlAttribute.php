<?php

namespace WebTheory\Html\Attributes;

use WebTheory\Html\Contracts\HtmlAttributeInterface;

class HtmlAttribute extends AbstractHtmlAttribute implements HtmlAttributeInterface
{
    /**
     *
     */
    protected $attrubute;

    /**
     * @var string
     */
    protected $value;

    /**
     *
     */
    public function __construct($attrubute)
    {
        $this->attrubute = $attrubute;
    }

    /**
     *
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     *
     */
    public function parse(): string
    {
        return (string) $this->value;
    }
}
