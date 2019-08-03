<?php

namespace Backalley\WordPress\MetaBox;

use Timber\Timber;
use Backalley\Backalley;
use Backalley\Wordpress\Fields\AbstractField;
use Backalley\Wordpress\Fields\Contracts\DataFieldInterface;
use Backalley\WordPress\MetaBox\Contracts\MetaboxContentInterface;


class Field extends AbstractField implements MetaboxContentInterface, DataFieldInterface
{
    /**
     * @var string
     */
    public $submitButton;

    /**
     * @var array
     */
    public $hiddenInput;

    /**
     *
     */
    protected $template = 'metabox__field.twig';

    /**
     *
     */
    protected $postType = 'ba_menu_item';

    /**
     *
     */
    public function hook()
    {
        add_action("save_post_{$this->postType}", [$this, 'saveData'], null, PHP_INT_MAX);

        return $this;
    }

    /**
     *
     */
    protected function getData($post)
    {
        return $this->dataManager->getData($post);
    }

    /**
     *
     */
    public function saveData($postId, $post, $update)
    {
        $this->dataManager->saveData($post, $this->processInput());
    }

    /**
     *
     */
    protected function setFormFieldValue($post)
    {
        $this->formField->setValue($this->getData($post));
    }

    /**
     *
     */
    public function render($post)
    {
        $this->setFormFieldValue($post);

        // exit(var_dump($this->formField));

        $context = [
            'label' => $this->label,
            'description' => $this->description,
            'attributes' => $this->attributes,
            'field' => $this->formField,
            'hidden' => $this->hiddenInput,
            'submit_button' => $this->submitButton,
        ];

        $this->renderTemplate($context);
    }

    /**
     *
     */
    protected function renderTemplate($context)
    {
        // Backalley::renderTemplate($this->template, $context);
        Timber::render($this->template, $context);
    }
}
