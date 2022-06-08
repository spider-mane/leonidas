<?php

namespace Leonidas\Library\System\Model;

use Closure;
use Jawira\CaseConverter\CaseConverter;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;

class SetAccessProvider implements SetAccessProviderInterface
{
    use ConvertsCaseTrait;

    protected Closure $enclosure;

    protected array $setters = [];

    public function __construct(object $instance, array $setters = [])
    {
        $this->enclosure = fn () => $instance;
        $this->setters = $setters;
        $this->caseConverter = new CaseConverter();
    }

    public function set(string $property, $value): void
    {
        $instance = $this->releaseInstance();

        if ($setter = $this->setters[$property] ?? null) {
            $setter instanceof Closure
                ? $setter($value)
                : $instance->$setter($value);

            return;
        }

        $setter = $this->prefixPascal('set', $property);

        if (is_callable([$instance, $setter])) {
            $this->setters[$property] = $setter;

            $instance->$setter($value);
        }
    }

    protected function releaseInstance(): object
    {
        return ($this->enclosure)();
    }
}
