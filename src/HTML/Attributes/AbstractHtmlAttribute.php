<?php

namespace WebTheory\Html\Attributes;

use WebTheory\Html\Contracts\HtmlAttributeInterface;

abstract class AbstractHtmlAttribute implements HtmlAttributeInterface
{
    /**
     *
     */
    protected $attribute;
    /**
     *
     */
    public function __toString()
    {
        return $this->getAttribute();
    }

    /**
     *
     */
    public function getAttribute(): string
    {
        $attr = $this::ATTRIBUTE ?? $this->attrubute;
        $val = $this->parse();

        return "{$attr}=\"{$val}\"";
    }
}
