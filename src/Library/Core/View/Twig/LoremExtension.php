<?php

namespace Leonidas\Library\Core\View\Twig;

use joshtronic\LoremIpsum;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;

class LoremExtension extends AbstractExtension implements ExtensionInterface
{
    public function getFunctions()
    {
        return [
            new TwigFunction('lorem', [$this, 'lorem']),
        ];
    }

    public function lorem()
    {
        return new LoremIpsum();
    }
}
