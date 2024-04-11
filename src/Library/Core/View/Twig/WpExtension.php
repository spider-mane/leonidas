<?php

namespace Leonidas\Library\Core\View\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class WpExtension extends AbstractExtension
{
    public function getFilters()
    {
        $filters = [
            'url' => home_url(...),
        ];

        $twigFilters = [];

        foreach ($filters as $name => $callable) {
            $twigFilters[] = new TwigFilter($name, $callable);
        }

        return $twigFilters;
    }
}
