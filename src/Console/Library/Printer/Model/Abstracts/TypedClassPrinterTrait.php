<?php

declare(strict_types=1);

namespace Leonidas\Console\Library\Printer\Model\Abstracts;

use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;
use ReflectionClass;
use ReflectionMethod;

trait TypedClassPrinterTrait
{
    use ConvertsCaseTrait;

    protected string $type;

    protected bool $isDoingTypeMatch = false;

    public function printFromType(): string
    {
        $this->isDoingTypeMatch = true;

        $output = $this->print($this->getSignaturesFromType());

        $this->isDoingTypeMatch = false;

        return $output;
    }

    protected function getSignaturesFromType(): array
    {
        $defaults = $this->getDefaultSignatures();
        $templates = $this->getMethodTemplates();

        $signatures = [];

        foreach ($this->getTypeMethods() as $method) {
            $name = $method->getName();

            // output if method matches default signature
            if ($defaults[$name] ?? false) {
                $signatures[$name] = $defaults[$name];

                continue;
            }

            // output if method matches template signature
            foreach ($templates as $template => $signature) {
                $pattern = '/^' . str_replace('*', '\w+', $template) . '$/';

                if (!preg_match($pattern, $name = $name)) {
                    continue;
                }

                $pass = $signature['pass'] ?? false
                    ? $this->convertParamsToPass($template, $signature, $method)
                    : '';

                $signatures[$name] = [
                    'take' => $this->convertParamsToTake($method),
                    'give' => $signature['give'] ?? null,
                    'call' => $signature['call'],
                    'pass' => $pass,
                ];

                continue 2;
            }
        }

        return $signatures;
    }

    protected function convertParamsToPass(string $template, array $signature, ReflectionMethod $method): string
    {
        $base = str_replace(explode('*', $template), '', $method->getName());

        $key = $this->convert($base)->toSnake();
        $var = $this->convert($base)->toCamel();

        return str_replace(
            ['#*', '$*'],
            ["'{$key}'", "\${$var}"],
            $signature['pass']
        );
    }

    protected function convertParamsToTake(ReflectionMethod $method): string
    {
        $params = $method->getParameters();

        $take = [];

        foreach ($params as $param) {
            $structure = '';

            if ($param->allowsNull()) {
                $structure .= '?';
            }

            if ($param->hasType()) {
                $type = $param->getType()->getName(); // @phpstan-ignore-line

                if ($this->typeIsConstruct($type)) {
                    $this->addImport($type);
                }

                $structure .= $type . ' ';
            }

            if ($param->isPassedByReference()) {
                $structure .= '&';
            }

            if ($param->isVariadic()) {
                $structure .= '...';
            }

            $structure .= '$' . $param->getName();

            if ($param->isDefaultValueAvailable()) {
                $structure .= ' = ' . (string) $param->getDefaultValue();
            }

            $take[] = $structure;
        }

        return implode(', ', $take);
    }

    protected function typeIsConstruct(string $type): bool
    {
        return class_exists($type)
            || interface_exists($type)
            || enum_exists($type);
    }

    protected function matchTraitsToType(array $traits, array $map)
    {
        $extensions = array_values(class_implements($this->type));

        return array_filter(
            $traits,
            fn ($partial) => in_array($map[$partial], $extensions)
        );
    }

    /**
     * @return ReflectionMethod[]
     */
    protected function getTypeMethods(): array
    {
        $reflection = new ReflectionClass($this->type);

        return $reflection->getMethods();
    }

    protected function isDoingTypeMatch(): bool
    {
        return $this->isDoingTypeMatch;
    }

    protected function getMethodTemplates(): array
    {
        return [];
    }

    abstract protected function addImport(string $import): void;

    abstract protected function print(array $methods): string;

    abstract protected function getDefaultSignatures(): array;
}
