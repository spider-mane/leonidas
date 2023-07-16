<?php

namespace Leonidas\Tasks\Make\Abstracts;

use Leonidas\Tasks\Make\PsrPrinterFactory;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\InterfaceType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Printer;
use Nette\PhpGenerator\TraitType;

abstract class AbstractClassPrinter
{
    public const CORE = 'core';

    protected const SIGNATURES = [];

    protected string $namespace;

    protected string $class;

    private array $imports = [];

    public function __construct(string $namespace, string $class)
    {
        $this->namespace = $namespace;
        $this->class = $class;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getClassFqn(): string
    {
        return $this->namespace . '\\' . $this->class;
    }

    public function printFile(): string
    {
        return $this->print($this->getDefaultSignatures());
    }

    protected function print(array $methods): string
    {
        $file = new PhpFile();
        $namespace = $file->addNamespace($this->namespace);
        $class = $this->setupClass($namespace);

        if (!$class->isInterface()) {
            $file->setStrictTypes(true);
        }

        $this->addMethods($class, $methods);
        $this->finishClass($class);

        array_map([$namespace, 'addUse'], $this->imports);

        $this->imports = [];

        return $this->getPrinter()->printFile($file);
    }

    protected function addImport(string $import): void
    {
        $this->imports[] = $import;
    }

    protected function getPrinter(): Printer
    {
        return PsrPrinterFactory::create();
    }

    protected function getDefaultSignatures(): array
    {
        return static::SIGNATURES;
    }

    /**
     * @param ClassType|InterfaceType|TraitType $class
     * @param array<string,array<string,string>> $signatures
     */
    protected function addMethods($class, array $signatures): void
    {
        foreach ($signatures as $method => $signature) {
            $this->addMethod($class, $method, $signature);
        }
    }

    /**
     * @param ClassType|InterfaceType|TraitType $class
     */
    protected function addMethod($class, string $name, array $signature): void
    {
        $take = $signature['take'] ?? '';
        $give = $signature['give'] ?? 'void';
        $call = $signature['call'] ?? $name;
        $pass = $signature['pass'] ?? '';

        $swap = $this->getMethodPassReplacements();
        $pass = str_replace($swap[0], $swap[1], $pass);

        $swap = $this->getMethodGiveReplacements();
        $return = str_replace(
            [...$swap[0], ...$strip = ['?', '&'], '$this'],
            [...$swap[1], ...$this->mapSymbols($strip), $this->getClassFqn()],
            $give
        );

        $method = $class->addMethod($name)
            ->setVariadic(str_contains($take, '...'))
            ->setReturnNullable(str_starts_with($give, '?'))
            ->setReturnReference(str_starts_with($give, '&'))
            ->setReturnType($return)
            ->setPublic();

        if (!$class->isInterface()) {
            $method->setBody($this->getMethodBody($call, $pass, $give));
        }

        $params = ($take = $signature['take'] ?? false)
            ? explode(', ', $take)
            : [];

        foreach ($params as $param) {
            $this->addParameter($method, $param);
        }

        if ('$this' === $give) {
            $method->addComment('@return ' . '$this');
        }
    }

    protected function getMethodPassReplacements(): array
    {
        return [[], []];
    }

    protected function getMethodGiveReplacements(): array
    {
        return [[], []];
    }

    protected function getMethodBody(string $call, string $pass, string $give): string
    {
        $action = sprintf('$this->%s->%s(%s);', static::CORE, $call, $pass);

        return ('void' === $give) ? $action : 'return ' . $action;
    }

    protected function addParameter(Method $method, string $param): void
    {
        $parts = $this->getParameterParts($param);

        $swap = $this->getParameterNameReplacements();
        $name = str_replace(
            [...$swap[0], ...$strip = ['$', '?', '&', '...']],
            [...$swap[1], ...$this->mapSymbols($strip)],
            $base = $parts['name']
        );

        $parameter = $method->addParameter($name)
            ->setReference(str_starts_with($base, '&'));

        if ($parts['has_type']) {
            $swap = $this->getParameterTypeReplacements();
            $type = str_replace(
                [...$swap[0], ...$strip = ['*']],
                [...$swap[1], ...$this->mapSymbols($strip)],
                $base = $parts['type']
            );

            $parameter->setType($type)->setNullable(str_starts_with($base, '?'));
        }

        if ($parts['has_default']) {
            $default = $parts['default'];

            if ('null' === $default) {
                $default = null;
            } elseif ('true' === $default) {
                $default = true;
            } elseif ('false' === $default) {
                $default = false;
            } elseif (is_numeric($default)) {
                $default = (int) $default;
            } elseif (is_string($default)) {
                $default = trim($default, '\'"');
            }

            $parameter->setDefaultValue($default);
        }
    }

    protected function getParameterParts(string $param): array
    {
        $param = preg_replace('/\s/', ' ', trim($param));
        $parts = array_pad(explode(' ', $param), 4, '');

        switch ($param) {
            case sprintf('%s %s = %s', $parts[0], $parts[1], $parts[3]):
                return [
                    'has_type' => true,
                    'has_default' => true,
                    'type' => $parts[0],
                    'name' => $parts[1],
                    'default' => $parts[3],
                ];

            case sprintf('%s %s', $parts[0], $parts[1]):
                return [
                    'has_type' => true,
                    'has_default' => false,
                    'type' => $parts[0],
                    'name' => $parts[1],
                ];

            case sprintf('%s = %s', $parts[0], $parts[1]):
                return [
                    'has_type' => false,
                    'has_default' => true,
                    'name' => $parts[0],
                    'default' => $parts[1],
                ];

            case sprintf('%s', $parts[0]):
            default:
                return [
                    'has_type' => false,
                    'has_default' => false,
                    'name' => $parts[0],
                ];
        }
    }

    protected function mapSymbols(array $symbols): array
    {
        return array_pad([], count($symbols), '');
    }

    protected function getParameterTypeReplacements(): array
    {
        return [[], []];
    }

    protected function getParameterNameReplacements(): array
    {
        return [[], []];
    }

    /**
     * @param ClassType|InterfaceType|TraitType $class
     */
    protected function finishClass($class): void
    {
        //
    }

    /**
     * @return ClassType|TraitType|InterfaceType
     */
    abstract protected function setupClass(PhpNamespace $namespace): object;
}
