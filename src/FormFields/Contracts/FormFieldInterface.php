<?php

namespace Backalley\FormFields\Contracts;

interface FormFieldInterface
{
    /**
     *
     */
    public function __toString();

    /**
     *
     */
    public function setValue($value);

    /**
     *
     */
    public function getValue();

    /**
     *
     */
    public function setName(string $name);

    /**
     *
     */
    public function getName(): string;

    /**
     *
     */
    public function setId(string $id);

    /**
     *
     */
    public function getId(): string;
}
