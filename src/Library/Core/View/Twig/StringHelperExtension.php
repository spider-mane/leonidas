<?php

namespace Leonidas\Library\Core\View\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;

class StringHelperExtension extends AbstractExtension implements ExtensionInterface
{
    public function getFunctions()
    {
        $functions = [
            'spaces' => 'spaces',
            'separate' => 'separate',
            'prefix' => 'prefix',
            'suffix' => 'suffix',
            'prefix_list' => 'prefixList',
            'suffix_list' => 'suffixList',
        ];

        $definitions = [];

        foreach ($functions as $name => $method) {
            $definitions[] = new TwigFunction($name, [$this, $method]);
        }

        return $definitions;
    }

    public function spaces(int $spaces)
    {
        return str_repeat('&nbsp;', $spaces);
    }

    public function separate(int $spaces, string $separator = '|')
    {
        $spaces = str_repeat('&nbsp;', $spaces);

        return $spaces . $separator . $spaces;
    }

    public function prefix(string $prefix, string $string)
    {
        return $prefix . $string;
    }

    public function prefixList(string $prefix, string ...$items)
    {
        return array_map(fn ($item) => $prefix . $item, $items);
    }

    public function suffix(string $suffix, string $string)
    {
        return $string . $suffix;
    }

    public function suffixList(string $suffix, string ...$items)
    {
        return array_map(fn ($item) => $item . $suffix, $items);
    }
}
