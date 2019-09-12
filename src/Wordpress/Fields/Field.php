<?php

namespace Backalley\Wordpress\Fields;

use Backalley\Form\Field as BaseField;
use Backalley\Wordpress\Fields\Managers\Factory as ManagerFactory;

class Field extends BaseField
{
    /**
     *
     */
    protected $controller = WpAdminField::class;

    /**
     *
     */
    protected function getDataManager($args)
    {
        $manager = $args['@create'];
        unset($args['@create']);

        return (new ManagerFactory)->create($manager, $args);
    }
}
