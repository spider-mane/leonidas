<?php

namespace WebTheory\WordPress\Fields;

use WebTheory\Saveyour\Contracts\MultiFieldFactoryInterface;
use WebTheory\Saveyour\FormFieldFactory;

class Factory extends FormFieldFactory implements MultiFieldFactoryInterface
{
    public const NAMESPACES = [
        'webtheory.wordpress' => __NAMESPACE__
    ] + parent::NAMESPACES;

    public const FIELDS = [] + parent::FIELDS;
}
