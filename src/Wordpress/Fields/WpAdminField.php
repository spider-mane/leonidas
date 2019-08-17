<?php

namespace Backalley\Wordpress\Fields;

use Backalley\Form\Controllers\FormFieldController;

class WpAdminField extends FormFieldController
{
    protected $filter = 'sanitize_textarea_field';
}
