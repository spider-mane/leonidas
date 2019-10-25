<?php

namespace WebTheory\Leonidas;

use WebTheory\Leonidas\Fields\WpAdminField;

class ObjectMetaManager extends WpAdminField
{
    /**
     * @var string
     */
    protected $objectType;

    /**
     * @var string
     */
    protected $metaKey;

    /**
     * @var string
     */
    protected $objectSubtype;

    /**
     * @var string
     */
    protected $dataType = 'string';

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $single;

    /**
     * @var string
     */
    protected $sanitizeCallback;

    /**
     * @var string
     */
    protected $authCallback;

    /**
     * @var bool
     */
    protected $showInRest;

    /**
     *
     */
    public function __construct(string $objectType, string $metaKey)
    {
        $this->objectSubtype = $objectType;
        $this->metaKey = $metaKey;
    }

    /**
     * Get the value of objectType
     *
     * @return string
     */
    public function getObjectType(): string
    {
        return $this->objectType;
    }

    /**
     * Get the value of metaKey
     *
     * @return string
     */
    public function getMetaKey(): string
    {
        return $this->metaKey;
    }

    /**
     * Get the value of objectSubtype
     *
     * @return string
     */
    public function getObjectSubtype(): string
    {
        return $this->objectSubtype;
    }

    /**
     * Set the value of objectSubtype
     *
     * @param string $objectSubtype
     *
     * @return self
     */
    public function setObjectSubtype(string $objectSubtype)
    {
        $this->objectSubtype = $objectSubtype;

        return $this;
    }

    /**
     * Get the value of dataType
     *
     * @return string
     */
    public function getDataType(): string
    {
        return $this->dataType;
    }

    /**
     * Set the value of dataType
     *
     * @param string $dataType
     *
     * @return self
     */
    public function setDataType(string $dataType)
    {
        $this->dataType = $dataType;

        return $this;
    }

    /**
     * Get the value of description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param string $description
     *
     * @return self
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of sanitizeCallback
     *
     * @return callable
     */
    public function getSanitizeCallback(): callable
    {
        return $this->sanitizeCallback;
    }

    /**
     * Set the value of sanitizeCallback
     *
     * @param callable $sanitizeCallback
     *
     * @return self
     */
    public function setSanitizeCallback(callable $sanitizeCallback)
    {
        $this->sanitizeCallback = $sanitizeCallback;

        return $this;
    }

    /**
     * Get the value of authCallback
     *
     * @return callable
     */
    public function getAuthCallback(): callable
    {
        return $this->authCallback;
    }

    /**
     * Set the value of authCallback
     *
     * @param callable $authCallback
     *
     * @return self
     */
    public function setAuthCallback(callable $authCallback)
    {
        $this->authCallback = $authCallback;

        return $this;
    }

    /**
     * Get the value of showInRest
     *
     * @return bool
     */
    public function getShowInRest(): bool
    {
        return $this->showInRest;
    }

    /**
     * Set the value of showInRest
     *
     * @param bool $showInRest
     *
     * @return self
     */
    public function setShowInRest(bool $showInRest)
    {
        $this->showInRest = $showInRest;

        return $this;
    }

    /**
     *
     */
    public function register()
    {
        $args = [
            'object_subtype' => $this->objectSubtype,
            'type' => $this->dataType,
            'description' => $this->description,
            'single' => $this->single,
            'sanitize_callback' => [$this, 'processInput'],
            'auth_callback' => $this->authCallback,
            'show_in_rest' => $this->showInRest,
        ];

        register_meta($this->objectType, $this->metaKey, $args);
    }

    /**
     *
     */
    public function processInput($input)
    {
        if (!isset($this->sanitizeCallback)) {
            $input = $this->filterInput($input);
        } else {
            $input = ${$this->sanitizeCallback}($input, $this);
        }

        return $input;
    }

    /**
     *
     */
    protected function filterInput($input)
    {
        if (true === $this->validateInput($input)) {
            return $this->sanitizeInput($input);
        } else {
            return false;
        }
    }

    /**
     *
     */
    protected function handleRuleViolation($rule)
    {
        return $this;
    }
}
