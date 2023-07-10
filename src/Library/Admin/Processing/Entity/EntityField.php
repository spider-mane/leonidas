<?php

namespace Leonidas\Library\Admin\Processing\Entity;

use Leonidas\Library\Admin\Component\Notice\StandardAdminNotice;
use WebTheory\Saveyour\Contracts\Validation\ValidationProcessorInterface;

abstract class EntityField implements ValidationProcessorInterface
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

    protected array $alerts = [];

    public function register()
    {
        $args = [
            'object_subtype' => $this->objectSubtype,
            'type' => $this->dataType,
            'description' => $this->description,
            'single' => $this->single,
            'sanitize_callback' => [$this, 'handleInput'],
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

    public function returnOnFailure(): mixed
    {
        return get_metadata(
            static::OBJECT_TYPE,
            (static::GET_OBJECT_FUNCTION)()->{static::OBJECT_ID_KEY},
            $this->metaKey
        );
    }

    public function handleRuleViolation(string $rule): void
    {
        $alert = $this->alerts[$rule] ?? null;

        if ($alert) {
            // new StandardAdminNotice($alert['id'], $alert['message']);
        }
    }
}
