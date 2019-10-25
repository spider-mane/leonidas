<?php

namespace WebTheory\WordPress\Fields;

use WebTheory\Form\Controllers\FormFieldController;

class WpAdminField extends FormFieldController
{
    protected $filter = 'sanitize_textarea_field';
}
