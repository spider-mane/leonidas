<?php

namespace Backalley\FormFields\Fields;

use Backalley\Html\TagSage;
use Backalley\GuctilityBelt;
use Backalley\FormFields\Contracts\FormFieldInterface;


class Input extends AbstractFormField implements FormFieldInterface
{
    /**
     * @var string
     */
    public $type = 'text';

    /**
     * @var string
     */
    public $name;

    /**
     * @var mixed
     */
    public $value;

    /**
     *
     */
    public function __construct()
    {
        // code here
    }

    /**
     * Get the value of type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param string  $type
     *
     * @return self
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     *
     */
    protected function resolveAttributes()
    {
        return parent::resolveAttributes()
            ->addAttribute('type', $this->type)
            ->addAttribute('value', $this->value);
    }

    /**
     *
     */
    public function toHtml()
    {
        $this->resolveAttributes();

        return $this->open('input', $this->attributes);
    }
}
