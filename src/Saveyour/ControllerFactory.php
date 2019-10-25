<?php

namespace WebTheory\Saveyour;

use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Controllers\FormFieldController;
use Illuminate\Support\Str;
use ReflectionClass;

class ControllerFactory
{
    /**
     *
     */
    protected $controller = FormFieldController::class;

    /**
     *
     */
    protected const SETTABLE = ['rules'];

    /**
     *
     */
    public function create($args): FormFieldController
    {
        $reflection = new ReflectionClass($this->controller);

        $postVar = $args['post_var'] ?? null;
        $formField = $args['form_field'] ?? null;
        $dataManager = $args['data_manager'] ?? null;

        $controller = $reflection->newInstance($postVar, $formField, $dataManager);

        foreach (static::SETTABLE as $property) {
            $setter = 'set' . Str::studly($property);
            $reflection->getMethod($setter)->invoke($controller, $args[$property]);
        }

        return $controller;
    }

    /**
     *
     */
    protected function setProperties($args, $instance)
    { }
}
