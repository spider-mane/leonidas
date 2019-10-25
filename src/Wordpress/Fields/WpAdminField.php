<?php

namespace WebTheory\WordPress\Fields;

use WebTheory\Saveyour\Controllers\FormFieldController;

class WpAdminField extends FormFieldController
{
    protected $filter = 'sanitize_textarea_field';
}
