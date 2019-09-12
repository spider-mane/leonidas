<?php

namespace Backalley\Form;

use Backalley\Form\Contracts\FieldDataManagerInterface;
use Backalley\Form\Contracts\FormFieldControllerInterface;
use Backalley\Form\Contracts\FormFieldInterface;
use Backalley\Form\Controllers\FormFieldController;
use Backalley\Form\DataManagerFactory;
use Backalley\Form\FieldFactory;
use Backalley\GuctilityBelt\Concerns\SmartFactoryTrait;
use Illuminate\Support\Collection;
use ReflectionClass;

class Field
{
    use SmartFactoryTrait;

    /**
     *
     */
    protected $controller = FormFieldController::class;

    /**
     *
     */
    public function create($args): FormFieldControllerInterface
    {
        $args['form_field'] = $this->getFormField($args['type'] ?? null);
        $args['data_manager'] = $this->getDataManager($args['data'] ?? null);

        unset($args['type'], $args['data'], $args['rules']);

        return $this->getController($args);
    }

    /**
     *
     */
    protected function getController($args): FormFieldControllerInterface
    {
        return $this->build($this->controller, Collection::make($args));
    }

    /**
     *
     */
    protected function getFormField($args)
    {
        $type = $args['@create'];
        unset($args['@create']);

        return (new FieldFactory)->create($type, $args);
    }

    /**
     *
     */
    protected function getDataManager($args)
    {
        $manager = $args['@create'];
        unset($args['@create']);

        return (new DataManagerFactory)->create($manager, $args);
    }
}
