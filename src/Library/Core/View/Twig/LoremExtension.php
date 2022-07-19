<?php

namespace Leonidas\Library\Core\View\Twig;

use joshtronic\LoremIpsum;
use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;

class LoremExtension extends AbstractExtension implements ExtensionInterface
{
    use ConvertsCaseTrait;

    public function getFunctions(): array
    {
        $functions = [];

        foreach (get_class_methods($lorem = new LoremIpsum()) as $method) {
            $name = 'lorem_' . $this->convert($method)->toSnake();

            $functions[] = new TwigFunction($name, [$lorem, $method]);
        }

        return $functions;
    }
}
