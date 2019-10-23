<?php

namespace Backalley\WordPress\Fields;

use Backalley\Form\Contracts\MultiFieldFactoryInterface;
use Backalley\Form\FormFieldFactory;

class Factory extends FormFieldFactory implements MultiFieldFactoryInterface
{
    public const NAMESPACES = [
        'webtheory.wordpress' => __NAMESPACE__
    ] + parent::NAMESPACES;

    public const FIELDS = [] + parent::FIELDS;
}
