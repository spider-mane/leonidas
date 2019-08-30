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
    public function tokenize();

    /**
     *
     */
    public function getAttribute(): string;
}
