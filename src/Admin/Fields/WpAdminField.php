<?php

namespace WebTheory\Leonidas\Admin\Fields;

use WebTheory\Saveyour\Controllers\FormFieldController;

class WpAdminField extends FormFieldController
{
    protected $filters = ['sanitize_textarea_field'];
}
