<?php

namespace Backalley\FormFields;

use Backalley\Html\AbstractHtmlElementConstructor;
use Backalley\FormFields\Contracts\FormFieldInterface;


abstract class AbstractFormField extends AbstractHtmlElementConstructor implements FormFieldInterface
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var mixed
     */
    public $value;

    /**
     * @var bool
     */
    public $required = false;

    /**
     * @var bool
     */
    public $disabled = false;

    /**
     * @var bool
     */
    public $readonly = false;

    /**
     *
     */
    public function __construct()
    {
        // maybe do something
    }

    /**
     * Get the value of id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param string  $id
     *
     * @return self
     */
    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string  $name
     *
     * @return self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @param mixed  $value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of required
     *
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * Set the value of required
     *
     * @param bool $required
     *
     * @return self
     */
    public function setRequired(bool $required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Get the value of disabled
     *
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * Set the value of disabled
     *
     * @param bool $disabled
     *
     * @return self
     */
    public function setDisabled(bool $disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get the value of readOnly
     *
     * @return bool
     */
    public function isReadOnly(): bool
    {
        return $this->readonly;
    }

    /**
     * Set the value of readOnly
     *
     * @param bool $readonly
     *
     * @return self
     */
    public function setReadOnly(bool $readonly)
    {
        $this->readonly = $readonly;

        return $this;
    }

    /**
     *
     */
    protected function resolveAttributes()
    {
        return $this
            ->addAttribute('id', $this->id)
            ->addAttribute('name', $this->name)
            ->addAttribute('disabled', $this->disabled)
            ->addAttribute('readonly', $this->readonly)
            ->addAttribute('required', $this->required);
    }

    /**
     *
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     *
     */
    abstract public function render();
}
