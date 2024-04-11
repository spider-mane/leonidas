<?php

namespace Leonidas\Library\Core\View\Twig;

use Faker\Factory;
use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use phpDocumentor\Reflection\DocBlockFactory;
use ReflectionClass;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;

class FakerExtension extends AbstractExtension implements ExtensionInterface
{
    use ConvertsCaseTrait;

    public function getFunctions(): array
    {
        $faker = Factory::create();
        $reflection = new ReflectionClass($faker);
        $parser = DocBlockFactory::createInstance();

        $doc = $reflection->getDocComment();

        /** @var Method[] $methods */
        $methods = $parser->create($doc)->getTagsByName('method');

        $functions = [];

        foreach ($methods as $method) {
            $method = $method->getMethodName();
            $name = 'fake_' . $this->convert($method)->toSnake();

            $functions[] = new TwigFunction($name, [$faker, $method]);
        }

        return $functions;
    }
}
