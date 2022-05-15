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
}
