<?php

namespace Backalley\Form;

use Backalley\Form\Contracts\FieldDataManagerInterface;
use Backalley\Form\Contracts\FormFieldControllerInterface;
use Backalley\Form\Contracts\FormFieldInterface;
use Backalley\Form\Contracts\MultiFieldDataManagerFactoryInterface as iDataManagerFactory;
use Backalley\Form\Contracts\MultiFieldFactoryInterface as iFormFieldFactory;
use Backalley\Form\Controllers\FormFieldController;
use Backalley\Form\FormFieldFactory;
use Backalley\GuctilityBelt\Concerns\SmartFactoryTrait;
use Illuminate\Support\Collection;

class FieldFactory
{
    use SmartFactoryTrait;

    /**
     * @var FormFieldFactory
     */
    protected $formFieldFactory;

    /**
     * @var DataManagerFactory
     */
    protected $dataManagerFactory;

    /**
     *
     */
    protected $controller = FormFieldController::class;

    /**
     *
     */
    public function __construct(iFormFieldFactory $formFieldFactory, iDataManagerFactory $dataManagerFactory, ?string $controller = null)
    {
        $this->formFieldFactory = $formFieldFactory;
        $this->dataManagerFactory = $dataManagerFactory;

        if (isset($controller)) {
            $this->controller = $controller;
        }
    }

    /**
     *
     */
    public function create($args): FormFieldControllerInterface
    {
        $args['form_field'] = $this->createFormField($args['type'] ?? null);
        $args['data_manager'] = $this->createDataManager($args['data'] ?? null);

        unset($args['type'], $args['data']);

        return $this->createController($args);
    }

    /**
     *
     */
    protected function createController($args): FormFieldControllerInterface
    {
        return $this->build($this->controller, Collection::make($args));
    }

    /**
     *
     */
    protected function createFormField($args): FormFieldInterface
    {
        $type = $args['@create'];

        unset($args['@create']);

        return $this->formFieldFactory->create($type, $args);
    }

    /**
     *
     */
    protected function createDataManager($args): FieldDataManagerInterface
    {
        $manager = $args['@create'];

        unset($args['@create']);

        return $this->dataManagerFactory->create($manager, $args);
    }
}
