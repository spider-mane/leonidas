<?php

namespace Leonidas\Library\System\Model;

use Closure;
use Jawira\CaseConverter\CaseConverter;
use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;

class GetAccessProvider implements GetAccessProviderInterface
{
    use ConvertsCaseTrait;

    protected Closure $enclosure;

    protected array $getters = [];

    public function __construct(object $instance, array $getters = [])
    {
        $this->enclosure = fn () => $instance;
        $this->getters = $getters;
        $this->caseConverter = new CaseConverter();
    }

    public function get(string $property)
    {
        $instance = $this->releaseInstance();

        if ($getter = $this->getters[$property] ?? false) {
            return $getter instanceof Closure
                ? $getter()
                : $instance->$getter();
        }

        $getter = $this->prefixPascal('get', $property);

        if (is_callable([$instance, $getter])) {
            $this->getters[$property] = $getter;

            return $instance->$getter();
        }

        $this->triggerNotice($property, $instance);
    }

    protected function releaseInstance(): object
    {
        return ($this->enclosure)();
    }

    protected function triggerNotice(string $property, object $instance): void
    {
        trigger_error(
            sprintf(
                "Undefined property: %s::%s",
                get_class($instance),
                $property
            ),
            E_USER_NOTICE
        );
    }
}
