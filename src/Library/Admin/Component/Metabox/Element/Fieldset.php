<?php

namespace Leonidas\Library\Admin\Component\Metabox\Element;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxComponentInterface;
use Leonidas\Contracts\Admin\Component\Metabox\MetaboxFieldInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;
use WebTheory\Saveyour\Contracts\Controller\FormFieldControllerInterface;

class Fieldset implements MetaboxComponentInterface
{
    use CanBeRestrictedTrait;

    protected string $title;

    protected array $fields = [];

    protected MetaboxComponentInterface $container;

    /**
     * horizontal padding for each field
     */
    protected int $rowPadding = 2;

    protected array $fieldOptions = [
        'submit_button' => null,
        'hidden_input' => null,
    ];

    protected array $containerOptions = [
        'padding' => 2,
    ];

    public function __construct(string $title, ?ServerRequestPolicyInterface $policy = null)
    {
        $this->title = $title;
        $this->policy = $policy;

        $this->container = $this->createContainer();
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
     * @return $this
     */
    public function setRowPadding(int $rowPadding)
    {
        $this->rowPadding = $rowPadding;

        return $this;
    }

    /**
     * Get the value of containerOptions
     *
     * @return array
     */
    public function getContainerOptions(): array
    {
        return $this->containerOptions;
    }

    /**
     * Set the value of containerOptions
     *
     * @param array $containerOptions
     *
     * @return $this
     */
    public function setContainerOptions(array $containerOptions)
    {
        $this->containerOptions = $containerOptions;

        return $this;
    }

    public function setContainerOption(string $option, $value)
    {
        $this->containerOptions[$option] = $value;

        return $this;
    }

    /**
     * Get the value of fieldOptions
     *
     * @return array
     */
    public function getFieldOptions(): array
    {
        return $this->fieldOptions;
    }

    /**
     * Set the value of fieldOptions
     *
     * @param array $fieldOptions
     *
     * @return $this
     */
    public function setFieldOptions(array $fieldOptions)
    {
        $this->fieldOptions = $fieldOptions;

        return $this;
    }

    public function setFieldOption(string $option, $value)
    {
        $this->fieldOptions[$option] = $value;

        return $this;
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

    public function setFields(array $fields)
    {
        $this->fields = [];

        $this->addFields($fields);

        return $this;
    }

    /**
     * Set the value of fields
     *
     * @param array $fields
     *
     * @return $this
     */
    public function addFields(array $fields)
    {
        foreach ($fields as $slug => $options) {
            $field = $options['field'];

            unset($options['field']);

            $this->addfield($slug, $field, $options);
        }

        return $this;
    }

    public function addField(string $slug, FormFieldControllerInterface $field, array $options = [])
    {
        if (isset($this->formController)) {
            $this->formController->addField($field);
        }

        $field = $this->createFieldContainer($field, $options)
            ->setLabel($options['label'] ?? $field->getFormField()->getLabel() ?? '')
            ->setDescription($options['description'] ?? '');

        $this->container->addContent($slug, $field);

        $this->fields[$slug] = $field;

        return $this;
    }

    protected function createContainer(): MetaboxComponentInterface
    {
        return (new Section($this->title))->setIsFieldset(true);
    }

    protected function createFieldContainer(FormFieldControllerInterface $field, array $options): MetaboxFieldInterface
    {
        return new Field($field);
    }

    /**
     * Prepares field to be rendered by assigning fieldset global properties
     *
     * @param MetaboxFieldInterface $field
     */
    protected function prepareField($field)
    {
        return;
    }

    /**
     * Prepares container to be rendered by applying any options set for it
     *
     * @return MetaboxComponentInterface
     */
    protected function prepareContainer(): MetaboxComponentInterface
    {
        return $this->container->setPadding($this->containerOptions['padding']);
    }

    public function renderComponent(ServerRequestInterface $request): string
    {
        foreach ($this->fields as $field) {
            $field->setRowPadding($this->rowPadding);
            $this->prepareField($field);
        }

        return $this->prepareContainer()->renderComponent($request);
    }
}
