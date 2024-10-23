<?php

namespace Leonidas\Library\Core\View\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use WebTheory\Html\Attributes\Classlist;
use WebTheory\Html\Attributes\Style;
use WebTheory\Html\Html;

class HtmlExtension extends AbstractExtension
{
    public function getFunctions()
    {
        $functions = [
            'html_tag' => Html::tag(...),
            'html_attr' => Html::attributes(...),
            'html_class' => fn ($value = []) => new Classlist($value ?? []),
            'html_style' => fn ($value = []) => new Style($value ?? []),
        ];

        $twigFunctions = [];

        foreach ($functions as $name => $callable) {
            $twigFunctions[] = new TwigFunction($name, $callable);
        }

        return $twigFunctions;
    }
}
