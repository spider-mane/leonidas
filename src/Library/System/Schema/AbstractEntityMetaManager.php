<?php

namespace Leonidas\Library\System\Schema;

use Leonidas\Library\Admin\Component\Notice\StandardAdminNotice;
use WebTheory\Saveyour\Contracts\Formatting\InputFormatterInterface;
use WebTheory\Saveyour\Contracts\Validation\ValidatorInterface;
use WebTheory\Saveyour\Controller\InputPurifier;

abstract class AbstractEntityMetaManager extends InputPurifier
{
    /**
     * @var string
     */
    protected const OBJECT_TYPE = '';

    /**
     * @var string
     */
    protected const GET_OBJECT_FUNCTION = '';

    /**
     * @var string
     */
    protected const OBJECT_ID_KEY = '';

    protected string $metaKey;

    protected ?string $objectSubtype = null;

    protected string $dataType = 'string';

    protected ?string $description = null;

    protected ?bool $single = null;

    protected ?bool $showInRest = null;

    protected string $capability = 'edit_posts';

    protected ?string $authCallback;

    public function __construct(string $metaKey, ValidatorInterface $validator, InputFormatterInterface $formatter)
    {
        $this->metaKey = $metaKey;

        parent::__construct($validator, $formatter);
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
    public function isShownInRest(): bool
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
     * Get the value of capability
     *
     * @return string
     */
    public function getCapability(): string
    {
        return $this->capability;
    }

    /**
     * Set the value of capability
     *
     * @param string $capability
     *
     * @return self
     */
    public function setCapability(string $capability)
    {
        $this->capability = $capability;

        return $this;
    }

    public function register()
    {
        $args = [
            'object_subtype' => $this->objectSubtype,
            'type' => $this->dataType,
            'description' => $this->description,
            'single' => $this->single,
            'sanitize_callback' => $this->sanitizeCallback ?? [$this, 'filterInput'],
            'auth_callback' => $this->authCallback ?? $this->authorizeAction(),
            'show_in_rest' => $this->showInRest,
        ];

        register_meta(static::OBJECT_TYPE, $this->metaKey, $args);

        return $this;
    }

    protected function authorizeAction()
    {
        return function ($allowed, $metaKey, $objectId, $userId, $cap, $caps) {
            return current_user_can($this->capability, $objectId, $this->metaKey);
        };
    }

    protected function returnIfFailed()
    {
        return get_metadata(
            static::OBJECT_TYPE,
            (static::GET_OBJECT_FUNCTION)()->{static::OBJECT_ID_KEY},
            $this->metaKey
        );
    }

    protected function handleRuleViolation($rule): void
    {
        $alert = $this->alerts[$rule] ?? null;

        if ($alert) {
            new StandardAdminNotice($alert);
        }
    }
}
