<?php

namespace Leonidas\Library\Core\View\Twig;

use Composer\InstalledVersions;
use Faker\Factory;
use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use phpDocumentor\Reflection\DocBlockFactory;
use ReflectionClass;
use Smknstd\FakerPicsumImages\FakerPicsumImagesProvider;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;

class FakerExtension extends AbstractExtension implements ExtensionInterface
{
    use ConvertsCaseTrait;

    final public const IMAGE_EXTENSION = 'smknstd/fakerphp-picsum-images';

    public function getFunctions(): array
    {
        $fake = Factory::create();

        if ($this->imageExtensionIsInstalled()) {
            $fake->addProvider(new FakerPicsumImagesProvider($fake));
        }

        $unique = $fake->unique();

        $reflection = new ReflectionClass($fake);
        $parser = DocBlockFactory::createInstance();

        $doc = $reflection->getDocComment();

        /** @var Method[] $methods */
        $methods = $parser->create($doc)->getTagsByName('method');

        $functions = [];

        foreach ($methods as $method) {
            $method = $method->getMethodName();
            $format = $this->convert($method)->toSnake();

            $functions[] = new TwigFunction("fake_{$format}", [$fake, $method]);
            $functions[] = new TwigFunction("unique_{$format}", [$unique, $method]);
        }

        return $functions;
    }

    protected function imageExtensionIsInstalled(): bool
    {
        return InstalledVersions::isInstalled(static::IMAGE_EXTENSION, true);
    }
}
