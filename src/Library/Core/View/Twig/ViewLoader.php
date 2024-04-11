<?php

namespace Leonidas\Library\Core\View\Twig;

use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;
use Twig\Source;

class ViewLoader implements LoaderInterface
{
    public const DEFAULT_NAMESPACE = '__main__';

    public const DEFAULT_EXTENSION = 'twig';

    private array $cache = [];

    public function __construct(
        protected FilesystemLoader $loader,
        protected string $views = '',
        protected string $namespace = self::DEFAULT_NAMESPACE,
        protected string $ext = self::DEFAULT_EXTENSION
    ) {
        //
    }

    public function getSourceContext(string $name): Source
    {
        return $this->loader->getSourceContext($this->resolveName($name));
    }

    public function getCacheKey(string $name): string
    {
        return $this->loader->getCacheKey($this->resolveName($name));
    }

    public function isFresh(string $name, int $time): bool
    {
        return $this->loader->isFresh($this->resolveName($name), $time);
    }

    public function exists(string $name): bool
    {
        return $this->loader->exists($this->resolveName($name));
    }

    protected function resolveName(string $name): string
    {
        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        if (in_array($name, $this->cache)) {
            return $name;
        }

        return $this->cache[$name] = $this->convertName($name);
    }

    protected function convertName(string $name): string
    {
        return $this->appendExtension(
            $this->prependNamespace($this->replaceDelimiters($name))
        );
    }

    protected function prependNamespace(string $name): string
    {
        return "@{$this->namespace}/{$name}";
    }

    protected function replaceDelimiters(string $name): string
    {
        return str_replace('.', DIRECTORY_SEPARATOR, $name);
    }

    protected function appendExtension(string $name): string
    {
        return "{$name}.{$this->ext}";
    }
}
