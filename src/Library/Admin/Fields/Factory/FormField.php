<?php

namespace Leonidas\Library\Admin\Fields\Factory;

use WebTheory\Saveyour\Contracts\Factory\FormFieldResolverFactoryInterface;
use WebTheory\Saveyour\Factory\FormFieldFactory;

class FormField extends FormFieldFactory implements FormFieldResolverFactoryInterface
{
    public const NAMESPACES = [
        'webtheory.leonidas' => __NAMESPACE__,
    ] + parent::NAMESPACES;

    public const FIELDS = [] + parent::FIELDS;
}
