<?php

namespace Leonidas\Library\System\Model;

use Closure;
use Jawira\CaseConverter\CaseConverter;
use Jawira\CaseConverter\CaseConverterInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;

class SetAccessProvider implements SetAccessProviderInterface
{
    protected object $instance;

    protected array $setters = [];

    protected CaseConverterInterface $caseConverter;

    public function __construct(object $instance, array $setters = [])
    {
        $this->instance = $instance;
        $this->setters = $setters;
        $this->caseConverter = new CaseConverter();
    }

    public function set(string $property, $value)
    {
        if ($setter = $this->setters[$property] ?? null) {
            $setter instanceof Closure
                ? $setter($value)
                : $this->instance->$setter($value);
        }

        $setter = $this->inferSetter($property);

        if (is_callable([$this->instance, $setter])) {
            $this->setters[$property] = $setter;

            $this->instance->$setter($value);
        }
    }

    protected function inferSetter(string $property): string
    {
        return 'set' . $this->caseConverter->convert($property)->toPascal();
    }
}
