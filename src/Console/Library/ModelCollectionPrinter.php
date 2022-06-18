<?php

namespace Leonidas\Console\Library;

use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;

class ModelCollectionPrinter
{
    public const SIGNATURES = [
        // 'getById' => [
        //     'take' => 'int $id',
        //     'give' => '@model',
        //     'call' => 'firstWhere',
        //     'pass' => "'id', '=', \$id",
        // ],
        'get' => [
            'take' => 'int $id',
            'give' => '@model',
            'call' => 'fetch',
            'pass' => '$id',
        ],
        'first' => [
            'give' => '@model',
        ],
        'last' => [
            'give' => '@model',
        ],
        'add' => [
            'pass' => '@single',
            'take' => '@model @single',
            'call' => 'insert',
        ],
        'collect' => [
            'pass' => '@plural',
            'take' => '@model ...@plural',
        ],
        'remove' => [
            'take' => 'int $id',
            'pass' => '$id',
        ],
        'merge' => [
            'take' => '@self ...@plural',
            'give' => '@self',
            'pass' => '...$this->expose(...@plural)',
        ],
        'diff' => [
            'take' => '@self ...@plural',
            'give' => '@self',
            'pass' => '...$this->expose(...@plural)',
        ],
        'contrast' => [
            'take' => '@self ...@plural',
            'give' => '@self',
            'pass' => '...$this->expose(...@plural)',
        ],
        'intersect' => [
            'take' => '@self ...@plural',
            'give' => '@self',
            'pass' => '...$this->expose(...@plural)',
        ],
        'filter' => [
            'take' => 'callable $callback',
            'give' => '@self',
            'pass' => '$callback',
        ],
        'sortBy' => [
            'take' => 'string $property, string $order = \'asc\'',
            'give' => '@self',
            'pass' => '$property, $order',
        ],
        'sortMapped' => [
            'take' => 'array $map, string $property, string $order = \'asc\'',
            'give' => '@self',
            'pass' => '$map, $property, $order',
        ],
    ];

    protected string $model;

    protected string $single;

    protected string $plural;

    protected string $namespace;

    protected string $class;

    protected string $type;

    public function __construct(string $model, string $single, string $plural, string $namespace, string $class, string $type)
    {
        $this->model = $model;
        $this->single = $single;
        $this->plural = $plural;
        $this->namespace = $namespace;
        $this->class = $class;
        $this->type = $type;
    }

    public function print(): string
    {
        $signatures = static::SIGNATURES;

        $base = AbstractModelCollection::class;
        $util = PoweredByModelCollectionKernelTrait::class;

        $printer = new PsrPrinter();
        $file = new PhpFile();
        $file->setStrictTypes(true);

        $namespace = $file->addNamespace($this->namespace)
            ->addUse($base)
            ->addUse($util)
            ->addUse($this->type)
            ->addUse($this->model);

        $class = $namespace->addClass($this->class)
            ->addExtend($base)
            ->addTrait($util)
            ->addImplement($this->type);

        $class->addConstant('MODEL_IDENTIFIER', 'id')->setProtected();
        $class->addConstant('COLLECTION_IS_MAP', true)->setProtected();

        foreach ($signatures as $method => $signature) {
            $call = $signature['call'] ?? $method;

            $pass = str_replace(
                ['@single', '@plural'],
                ['$' . $this->single, '$' . $this->plural],
                $signature['pass'] ?? ''
            );

            switch ($give = $signature['give'] ?? 'void') {
                case '@model':
                case '$this':
                    $return = $this->model;

                    break;

                case '@self':
                    $return = $this->namespace . '\\' . $this->class;

                    break;

                default:
                    $return = $give;

                    break;
            }

            $body = 'return $this->kernel->' . $call . '(' . $pass . ');';

            if ('void' === $give) {
                $body = str_replace('return ', '', $body);
            }

            $method = $class->addMethod($method)
                ->setReturnType($return)
                ->setBody($body);

            $params = ($take = $signature['take'] ?? false)
                ? explode(', ', $take)
                : [];

            foreach ($params as $param) {
                $parts = explode(' ', $param);

                $type = str_replace(
                    ['@model', '@self', '*'],
                    [$this->model, $this->type, ''],
                    $parts[0]
                );

                $sym = ['$', '?', '&', '...'];
                $map = array_pad([], count($sym), '');

                $name = str_replace(
                    ['@single', '@plural', ...$sym],
                    [$this->single, $this->plural, ...$map],
                    $parts[1]
                );

                if ('' === $name) {
                    dd($method, $parts);
                }

                $method->setVariadic(str_contains($parts[1], '...'));

                $parameter = $method->addParameter($name)
                    ->setType($type)
                    ->setNullable(str_contains($parts[1], '?'))
                    ->setReference(str_contains($parts[1], '&'));

                if ($default = $parts[3] ?? false) {
                    if ('null' === $default) {
                        $default = null;
                    } elseif ('true' === $default) {
                        $default = true;
                    } elseif ('false' === $default) {
                        $default = false;
                    } elseif (is_numeric($default)) {
                        $default = (int) $default;
                    } else {
                        $default = trim($default, '\'"');
                    }

                    $parameter->setDefaultValue($default);
                }
            }

            if ($give && '$this' === $give) {
                $method->addComment('@return ' . '$this');
            }
        }

        return $printer->printFile($file);
    }
}
