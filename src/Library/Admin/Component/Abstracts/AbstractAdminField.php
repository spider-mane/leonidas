<?php

namespace Leonidas\Library\Admin\Component\Abstracts;

use Leonidas\Contracts\Admin\Component\AdminFieldInterface;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\Controller\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\Field\FormFieldInterface;

abstract class AbstractAdminField implements AdminFieldInterface
{
    /**
     * label
     */
    protected ?string $label = null;

    /**
     * description
     */
    protected ?string $description = null;

    protected FormFieldControllerInterface $formFieldController;

    public function __construct(FormFieldControllerInterface $formFieldController)
    {
        $this->formFieldController = $formFieldController;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Set label
     *
     * @param string $label label
     *
     * @return $this
     */
    public function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description description
     *
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    public function renderInputField(ServerRequestInterface $request): string
    {
        return $this->formFieldController->render($request);
    }

    protected function renderFormField(ServerRequestInterface $request): FormFieldInterface
    {
        return $this->formFieldController->compose($request);
    }
}
