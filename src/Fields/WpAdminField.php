<?php

namespace WebTheory\Leonidas\Fields;

use WebTheory\Saveyour\Controllers\FormFieldController;

class WpAdminField extends FormFieldController
{
    protected $filters = ['sanitize_textarea_field'];
}
