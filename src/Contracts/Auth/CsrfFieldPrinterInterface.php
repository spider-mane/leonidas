<?php

namespace Leonidas\Contracts\Auth;

interface CsrfFieldPrinterInterface
{
    public function print(CsrfManagerInterface $manager): string;
}
