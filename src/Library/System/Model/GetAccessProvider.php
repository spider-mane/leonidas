<?php

namespace Leonidas\Library\System\Model;

use Closure;
use Jawira\CaseConverter\CaseConverter;
use Jawira\CaseConverter\CaseConverterInterface;
use Leonidas\Contracts\System\Model\GetAccessProviderInterface;

class GetAccessProvider implements GetAccessProviderInterface
{
    protected object $instance;

    protected array $getters = [];

    protected CaseConverterInterface $caseConverter;

    public function __construct(object $instance, array $getters = [])
    {
        $this->instance = $instance;
        $this->getters = $getters;
        $this->caseConverter = new CaseConverter();
    }

    public function get(string $property)
    {
        if ($getter = $this->getters[$property] ?? false) {
            return $getter instanceof Closure
                ? $getter()
                : $this->instance->$getter();
        }

        $getter = $this->inferGetter($property);

        if (is_callable([$this->instance, $getter])) {
            $this->getters[$property] = $getter;

            return $this->instance->$getter();
        }

        $this->triggerNotice($property);
    }

    protected function inferGetter(string $property): string
    {
        return 'get' . $this->caseConverter->convert($property)->toPascal();
    }

    protected function triggerNotice(string $property): void
    {
        trigger_error(
            sprintf(
                "Undefined property: %s::%s",
                get_class($this->instance),
                $property
            ),
            E_USER_NOTICE
        );
    }
}
