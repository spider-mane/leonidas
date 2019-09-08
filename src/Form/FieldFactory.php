<?php

namespace Backalley\Form;

use Backalley\Form\Contracts\FormFieldInterface;
use Backalley\Form\Contracts\MultiFieldFactoryInterface;
use Backalley\Form\Fields\Input;
use Backalley\GuctilityBelt\Concerns\SmartFactoryTrait;
use Backalley\Html\TagSage;
use Exception;
use Illuminate\Support\Collection;

class FieldFactory implements MultiFieldFactoryInterface
{
    use SmartFactoryTrait;

    /**
     *
     */
    private $fields = [];

    /**
     *
     */
    protected $namespace = [];

    protected const NAMESPACE = [
        "Backalley\\Form\\Fields"
    ];

    protected const FIELDS = [];

    /**
     *
     */
    public function __construct()
    {
        foreach (static::NAMESPACE as $namespace) {
            $this->addNamespace($namespace);
        }
        foreach (static::FIELDS as $arg => $field) {
            $this->addField($arg, $field);
        }
    }

    /**
     * Get the value of managers
     *
     * @return mixed
     */
    public function getFields()
    {
        return $this->managers;
    }

    /**
     * Set the value of managers
     *
     * @param mixed $managers
     *
     * @return self
     */
    public function addField(string $arg, string $manager)
    {
        $this->managers[$arg] = $manager;

        return $this;
    }

    /**
     *
     */
    public function create(string $field, array $args = []): FormFieldInterface
    {
        $class = $this->getClass($field);
        $args = Collection::make($args);

        if (isset($this->fields[$field])) {
            $field = $this->buildObject($this->fields[$field], $args);
        } elseif (false !== $class) {
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
        return $this->build($class, $args);
    }
}
