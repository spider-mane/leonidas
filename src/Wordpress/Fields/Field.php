<?php

namespace Backalley\Wordpress\Fields;

use Backalley\Form\Contracts\MultiFieldDataManagerFactoryInterface;
use Backalley\Form\Field as BaseField;
use Backalley\Wordpress\Fields\Managers\Factory as DataManagerFactory;

class Field extends BaseField
{
    /**
     *
     */
    protected $controller = WpAdminField::class;

    /**
     *
     */
    protected static function createDataManagerFactory(array $options): MultiFieldDataManagerFactoryInterface
    {
        return (new DataManagerFactory);
    }
}
