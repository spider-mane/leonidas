<?php

namespace Leonidas\Library\Admin;

use Psr\Http\Message\ServerRequestInterface;
use Leonidas\Contracts\Admin\Components\AdminFieldInterface;
use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\FormFieldInterface;

abstract class AbstractAdminField implements AdminFieldInterface
{
    /**
     * label
     *
     * @var string
     */
    protected $label;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * @var FormFieldControllerInterface
     */
    protected $formFieldController;

    /**
     *
     */
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
     * @param string  $label  label
     *
     * @return self
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
     * @return self
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     *
     */
    protected function renderFormField(ServerRequestInterface $request): FormFieldInterface
    {
        return $this->formFieldController->render($request);
    }
}
