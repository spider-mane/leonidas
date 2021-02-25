<?php

namespace WebTheory\Leonidas\Admin\Fields\Types;

use WebTheory\Saveyour\Contracts\FormFieldInterface;
use WebTheory\Saveyour\Fields\AbstractCompositeSelectionField;

class WpChecklist extends AbstractCompositeSelectionField implements FormFieldInterface
{
    /**
     *
     */
    protected function renderHtmlMarkup(): string
    {
        return '';
    }
}
