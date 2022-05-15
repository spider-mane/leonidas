<?php

namespace Leonidas\Library\System\Model;

use Closure;
use Jawira\CaseConverter\CaseConverter;
use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;

class GetAccessProvider implements GetAccessProviderInterface
{
    use ConvertsCaseTrait;

    protected object $instance;

    protected array $getters = [];

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

        $getter = $this->prefixPascal('get', $property);

        if (is_callable([$this->instance, $getter])) {
            $this->getters[$property] = $getter;

            return $this->instance->$getter();
        }

        $this->triggerNotice($property);
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
