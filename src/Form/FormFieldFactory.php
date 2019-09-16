<?php

namespace Backalley\Form;

use Backalley\Form\Contracts\FormFieldInterface;
use Backalley\Form\Contracts\MultiFieldFactoryInterface;
use Backalley\Form\Fields\Input;
use Backalley\GuctilityBelt\Concerns\SmartFactoryTrait;
use Backalley\Html\TagSage;
use Exception;
use Illuminate\Support\Collection;

class FormFieldFactory implements MultiFieldFactoryInterface
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

    /**
     *
     */
    protected $rules = [];

    protected const NAMESPACE = [
        "Backalley\\Form\\Fields"
    ];

    protected const FIELDS = [];

    /**
     *
     */
    public function __construct()
    {
        $this->namespace = static::NAMESPACE;
        $this->fields = static::FIELDS;
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
    public function addField(string $arg, string $field)
    {
        $this->fields[$arg] = $field;

        return $this;
    }

    /**
     *
     */
    public function addFields(array $fields)
    {
        foreach ($fields as $arg => $field) {
            $this->addField($arg, $field);
        }

        return $this;
    }

    /**
     *
     */
    public function create(string $field, array $args = []): FormFieldInterface
    {
        $args = Collection::make($args);
        $class = $this->getClass($field);

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
