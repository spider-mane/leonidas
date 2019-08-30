<?php

namespace Backalley\Html;

use Backalley\Html\Contracts\HtmlAttributeInterface;

abstract class AbstractHtmlAttribute implements HtmlAttributeInterface
{
    /**
     *
     */
    public function __toSting()
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
