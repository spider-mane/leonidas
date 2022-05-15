<?php

namespace Leonidas\Library\System\Model;

use Closure;
use Jawira\CaseConverter\CaseConverter;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;

class SetAccessProvider implements SetAccessProviderInterface
{
    use ConvertsCaseTrait;

    protected object $instance;

    protected array $setters = [];

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
        return 'set' . $this->convert($property)->toPascal();
    }
}
