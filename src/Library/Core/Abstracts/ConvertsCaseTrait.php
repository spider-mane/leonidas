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
}
