<?php

namespace Backalley\Html\Contracts;

interface HtmlAttributeInterface
{
    /**
     *
     */
    public function parse(): string;

    /**
     *
     */
    public function tokenize(string $attribute);

    /**
     *
     */
    public function getAttribute(): string;
}
