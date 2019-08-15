<?php

namespace Backalley\WordPress\MetaBox;

use Backalley\Wordpress\Fields\WpAdminField;
use Backalley\Form\Contracts\FormFieldInterface;
use Backalley\Form\Controllers\FormFieldController;
use Backalley\Form\Contracts\FieldDataManagerInterface;
use Backalley\Form\Contracts\FormFieldControllerInterface;
use Backalley\Form\Controllers\AbstractFormSubmissionManager;
use Backalley\WordPress\MetaBox\Contracts\MetaboxContentInterface;

class Fieldset implements MetaboxContentInterface
{
    /**
     *
     */
    protected $title = '';

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var array
     */
    protected $controllers = [];

    /**
     *
     */
    protected $formController;

    /**
     * @var Section
     */
    protected $container;

    /**
     * @var int
     */
    protected $rowPadding = 2;

    /**
     *
     */
    public function __construct(string $title, AbstractFormSubmissionManager $formController)
    {
        $this->title = $title;
        $this->formController = $formController;
        $this->container = (new Section($this->title))->setIsFieldset(true);
    }

    /**
     * Get the value of fields
     *
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Set the value of fields
     *
     * @param array  $fields
     *
     * @return self
     */
    public function setFields(array $fields)
    {
        foreach ($fields as $slug => $config) {

            $options = [
                'label' => $config['label'] ?? null,
                'description' => $config['description'] ?? null,
                'save_disabled' => $config['save_disabled'] ?? false,
            ];

            $this->addfield($slug, $config['type'], $config['data'] ?? null, $options);
        }

        return $this;
    }

    /**
     * Set the value of fields
     *
     * @param array  $fields
     *
     * @return self
     */
    public function addField(string $slug, FormFieldInterface $field, ?FieldDataManagerInterface $data = null, array $options = [])
    {
        $controller = (new WpAdminField($slug, $field, $data));

        if (isset($this->formController)) {
            $this->formController->addField($controller);
        }

        $scaffold = (new Field($slug, $controller))
            ->setLabel($options['label'] ?? $field->getLabel() ?? '')
            ->setDescription($options['description'] ?? '');

        $this->container->addContent($slug, $scaffold);

        $this->fields[$slug] = $scaffold;
        $this->controllers[$slug] = $controller;

        return $this;
    }

    /**
     * Get the value of rowPadding
     *
     * @return int
     */
    public function getRowPadding(): int
    {
        return $this->rowPadding;
    }

    /**
     * Set the value of rowPadding
     *
     * @param int $rowPadding
     *
     * @return self
     */
    public function setRowPadding(int $rowPadding)
    {
        $this->rowPadding = $rowPadding;

        return $this;
    }

    /**
     * Get the value of formController
     *
     * @return mixed
     */
    public function getFormController(): AbstractFormSubmissionManager
    {
        return $this->formController;
    }

    /**
     * Set the value of formController
     *
     * @param mixed $formController
     *
     * @return self
     */
    public function setFormController(AbstractFormSubmissionManager $formController)
    {
        $this->formController = $formController;

        return $this;
    }

    /**
     * Get the value of controllers
     *
     * @return array
     */
    public function getControllers(): array
    {
        return $this->controllers;
    }

    /**
     * Prepares field to be rendered by assigning fieldset global properties
     *
     * @var Field $field
     */
    protected function prepareField($field)
    {
        $field->setRowPadding($this->rowPadding);
    }

    /**
     *
     */
    public function render($post)
    {
        foreach ($this->fields as $field) {
            $this->prepareField($field);
        }

        return $this->container->render($post);
    }
}
