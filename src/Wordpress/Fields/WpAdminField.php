<?php

namespace Backalley\WordPress\Fields;

use Backalley\Form\Controllers\FormFieldController;

class WpAdminField extends FormFieldController
{
    protected $filter = 'sanitize_textarea_field';
}
