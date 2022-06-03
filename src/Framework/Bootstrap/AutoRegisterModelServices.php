<?php

namespace Leonidas\Framework\Bootstrap;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Panamax\Contracts\ServiceContainerInterface;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use RecursiveDirectoryIterator;
use ReflectionClass;
use TheSeer\Tokenizer\Tokenizer;

class AutoRegisterModelServices implements ExtensionBootProcessInterface
{
    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        $path = $extension->absPath($extension->config('app.models'));
        $domains = $this->createDirectoryIterator($path);

        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        $traverser = new NodeTraverser();
        $tokenizer = new Tokenizer();

        foreach ($domains as $domain) {
            if (!$domain->isDir()) {
                continue;
            }

            $domain = $this->createDirectoryIterator($domain->getPathname());

            foreach ($domain as $component) {
                $filename = $component->getFilename();

                if (!str_contains($filename, 'Repository.php')) {
                    continue;
                }

                include $component->getPathname();
                $classes = get_declared_classes();
                $class = end($classes);

                $reflection = new ReflectionClass($class);
                $annotations = $reflection->getDocComment();

                if (!str_contains($annotations, '@systemModel')) {
                    continue;
                }

                $contents = file_get_contents($component->getPathname());
            }
        }
    }

    protected function createDirectoryIterator(string $path): RecursiveDirectoryIterator
    {
        return new RecursiveDirectoryIterator(
            $path,
            RecursiveDirectoryIterator::SKIP_DOTS
        );
    }
}
