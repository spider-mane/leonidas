<?php

namespace Backalley\Html\Attributes;

use Backalley\Html\Contracts\HtmlAttributeInterface;

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
