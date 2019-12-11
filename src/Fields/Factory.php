<?php

namespace WebTheory\Leonidas\Fields;

use WebTheory\Saveyour\Contracts\FormFieldResolverFactoryInterface;
use WebTheory\Saveyour\Factories\FormFieldFactory;

class Factory extends FormFieldFactory implements FormFieldResolverFactoryInterface
{
    public const NAMESPACES = [
        'webtheory.leonidas' => __NAMESPACE__
    ] + parent::NAMESPACES;

    public const FIELDS = [] + parent::FIELDS;
}
