<?php

namespace Leonidas\Library\Admin\Fields;

use Leonidas\Library\Admin\Fields\Formatters\TermsToIdsDataFormatter;
use Leonidas\Library\Admin\Fields\Managers\PostTermDataManager;
use Leonidas\Library\Admin\Fields\Selections\TaxonomyChecklistItems;
use WebTheory\Saveyour\Contracts\ChecklistItemsProviderInterface;
use WebTheory\Saveyour\Contracts\DataFormatterInterface;
use WebTheory\Saveyour\Contracts\FieldDataManagerInterface;
use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\FormFieldInterface;
use WebTheory\Saveyour\Controllers\AbstractField;
use WebTheory\Saveyour\Fields\Checklist;

class TermChecklist extends AbstractField implements FormFieldControllerInterface
{
    protected $taxonomy;

    protected $options;

    public function __construct(string $taxonomy, string $requestVar, array $options = [])
    {
        $this->taxonomy = $taxonomy;
        $this->options = $this->defineOptions($options);

        parent::__construct($requestVar);
    }

    protected function defineOptions(array $options)
    {
        return [
            'id' => $options['id'] ?? "wts--{$this->taxonomy}-checklist",
            'class' => $options['class'] ?? [],
        ];
    }

    protected function defineFormField(): ?FormFieldInterface
    {
        $options = $this->options;

        return (new Checklist())
            ->setSelectionProvider($this->createSelection())
            ->setId($options['id'])
            ->setClasslist($options['class'])
            ->addClass('thing');
    }

    protected function createSelection(): ChecklistItemsProviderInterface
    {
        return new TaxonomyChecklistItems($this->taxonomy);
    }

    protected function defineDataManager(): ?FieldDataManagerInterface
    {
        return new PostTermDataManager($this->taxonomy);
    }

    protected function defineDataFormatter(): ?DataFormatterInterface
    {
        return new TermsToIdsDataFormatter();
    }

    protected function defineFilters(): ?array
    {
        return ['sanitize_text_field'];
    }
}
