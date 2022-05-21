<?php

namespace Leonidas\Library\Core\Auth;

use Leonidas\Contracts\Auth\CsrfFieldPrinterInterface;
use Leonidas\Contracts\Auth\CsrfManagerInterface;
use WebTheory\Saveyour\Field\Type\Hidden;

class CsrfFieldPrinter implements CsrfFieldPrinterInterface
{
    public function print(CsrfManagerInterface $manager): string
    {
        return (new Hidden())
            ->setName($manager->getName())
            ->setValue($manager->getToken())
            ->toHtml();
    }
}
