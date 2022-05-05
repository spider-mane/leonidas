<?php

namespace Leonidas\Library\Admin\Fields;

use Leonidas\Library\Admin\Fields\Formatters\TermsToIdsDataFormatter;
use Leonidas\Library\Admin\Fields\Managers\PostTermDataManager;
use Leonidas\Library\Admin\Fields\Selections\TaxonomyChecklistItems;
use WebTheory\Saveyour\Contracts\Controller\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\Data\FieldDataManagerInterface;
use WebTheory\Saveyour\Contracts\Field\FormFieldInterface;
use WebTheory\Saveyour\Contracts\Field\Selection\ChecklistItemsProviderInterface;
use WebTheory\Saveyour\Contracts\Formatting\DataFormatterInterface;
use WebTheory\Saveyour\Controller\Abstracts\AbstractField;
use WebTheory\Saveyour\Field\Type\Checklist;

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

        $checklist = new Checklist();
        $checklist->setSelectionProvider($this->createSelection())
            ->setId($options['id'])
            ->setClasslist($options['class'])
            ->addClass('thing');

        return $checklist;
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
