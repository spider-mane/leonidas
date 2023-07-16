<?php

namespace Leonidas\Tasks\Make\Abstracts;

abstract class AbstractTypedClassPrinter extends AbstractClassPrinter
{
    use TypedClassPrinterTrait;

    protected const TEMPLATES = [];

    public function __construct($namespace, $class, $type)
    {
        parent::__construct($namespace, $class);

        $this->type = $type;
    }

    public function getMethodTemplates(): array
    {
        return static::TEMPLATES;
    }
}
