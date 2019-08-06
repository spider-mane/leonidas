<?php

namespace Backalley\FormFields\Contracts;

interface FormFieldInterface
{
    /**
     * @param string|int|array $value The value(s) associated with the field
     */
    public function setValue($value);

    /**
     * @return string|int|array
     */
    public function getValue();

    /**
     * @param string $name
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $id
     */
    public function setId(string $id);

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param bool $disabled
     */
    public function setDisabled(bool $disabled);

    /**
     * @return bool
     */
    public function isDisabled(): bool;

    /**
     * @param bool $readonly
     */
    public function setReadOnly(bool $readonly);

    /**
     * @return bool
     */
    public function isReadOnly(): bool;

    /**
     * @param bool $readonly
     */
    public function setRequired(bool $required);

    /**
     * @return bool
     */
    public function isRequired(): bool;

    /**
     * @return string
     */
    public function __toString();
}
