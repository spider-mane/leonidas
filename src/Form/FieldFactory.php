<?php

namespace Backalley\Form;

use Backalley\Form\Contracts\FormFieldInterface;
use Backalley\Form\Fields\Input;
use Backalley\GuctilityBelt\Concerns\SmartFactory;
use Backalley\Html\TagSage;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use InvalidArgumentException;
use ReflectionClass;

class FieldFactory
{
    use SmartFactory;

    /**
     *
     */
    private $fields = [];

    /**
     *
     */
    protected const NAMESPACE = "Backalley\\Form\\Fields";

    /**
     *
     */
    public function create(string $field, array $args = []): FormFieldInterface
    {
        $class = $this->getFqn($field);
        $args = Collection::make($args);

        if (isset($this->fields[$field])) {
            $field = $this->buildObject($this->fields[$field], $args);
        } elseif (class_exists($class)) {
            $field = $this->buildObject($class, $args);
        } elseif (TagSage::isIt('standard_input_type', $field)) {
            $field = $this->buildObject(Input::class, $args->merge(['type' => $field]));
        } else {
            throw new Exception("{$field} is not a recognized field type");
        }

        return $field;
    }

    /**
     *
     */
    protected function buildObject(string $class, Collection $args): FormFieldInterface
    {
        $keys = $args->keys()->transform(function ($arg) {
            return $this->getParam($arg);
        });

        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        $params = $constructor->getParameters();

        $construct = [];

        foreach ($params as $param) {

            if ($keys->contains($param->name)) {

                $arg = $this->getArg($param->name);

                $construct[] = $args->get($arg);
                $args->forget($arg);
            }
        }

        $field = $reflection->newInstance(...$construct);

        foreach ($args as $property => $value) {
            $setter = $this->getSetter($property);

            if ($reflection->hasMethod($setter)) {
                $reflection->getMethod($setter)->invoke($field, $value);
            } else {
                throw new InvalidArgumentException("{$property} is not a settable property of {$reflection->name}::class");
            }
        }

        return $field;
    }

    /**
     *
     */
    protected function getSetter($property)
    {
        return 'set' . Str::studly($property);
    }

    /**
     *
     */
    protected function getArg($param)
    {
        return Str::snake($param);
    }

    /**
     *
     */
    protected function getParam($arg)
    {
        return Str::camel($arg);
    }

    /**
     *
     */
    protected function getFqn(string $class)
    {
        return static::NAMESPACE . "\\" . Str::studly($class);
    }

    /**
     *
     */
    public function __call($field, $args)
    {
        return $this->create($field, $args[0]);
    }

    /**
     *
     */
    public static function __callStatic($field, $args)
    {
        return (new static)->create($field, $args[0]);
    }
}
