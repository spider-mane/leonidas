<?php

namespace Leonidas\Library\Core\Abstracts;

use Jawira\CaseConverter\CaseConverterInterface;
use Jawira\CaseConverter\Convert;

trait ConvertsCaseTrait
{
    protected CaseConverterInterface $caseConverter;

    protected function convert(string $source): Convert
    {
        return isset($this->caseConverter)
            ? $this->caseConverter->convert($source)
            : new Convert($source);
    }

    protected function prefixPascal(string $prefix, string $source): string
    {
        return $prefix . $this->convert($source)->toPascal();
    }

    protected function prefixStudly(string $prefix, string $source): string
    {
        return $this->prefixPascal($prefix, $source);
    }

    protected function suffixPascal(string $suffix, string $source): string
    {
        return $this->convert($source)->toPascal() . $suffix;
    }

    protected function suffixStudly(string $suffix, string $source): string
    {
        return $this->suffixPascal($suffix, $source);
    }

    protected function prefixCamel(string $prefix, string $source): string
    {
        return $prefix . $this->convert($source)->toCamel();
    }

    protected function suffixCamel(string $suffix, string $source): string
    {
        return $this->convert($source)->toCamel() . $suffix;
    }
}
