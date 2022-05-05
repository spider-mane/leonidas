<?php

namespace Leonidas\Library\Admin\Fields\Types;

use WebTheory\Saveyour\Contracts\Field\FormFieldInterface;
use WebTheory\Saveyour\Field\Type\Abstracts\AbstractCompositeSelectionField;

class WpChecklist extends AbstractCompositeSelectionField implements FormFieldInterface
{
    protected function renderHtmlMarkup(): string
    {
        return '';
    }
}
