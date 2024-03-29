<?php

namespace Leonidas\Library\Admin\Field\Type;

use WebTheory\Saveyour\Contracts\Field\FormFieldInterface;
use WebTheory\Saveyour\Contracts\Field\Selection\SelectionProviderInterface;
use WebTheory\Saveyour\Field\Selection\ChecklistSelectionFromMap;
use WebTheory\Saveyour\Field\Type\Abstracts\AbstractCompositeSelectionField;

class WpChecklist extends AbstractCompositeSelectionField implements FormFieldInterface
{
    protected function renderHtmlMarkup(): string
    {
        return '';
    }

    protected function getSelectionProvider(): SelectionProviderInterface
    {
        return new ChecklistSelectionFromMap([]);
    }
}
