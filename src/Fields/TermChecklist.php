<?php

namespace WebTheory\Leonidas\Fields;

use WebTheory\Leonidas\Fields\Managers\PostTermDataManager;
use WebTheory\Leonidas\Fields\Selections\TaxonomyChecklistItems;
use WebTheory\Leonidas\Fields\Transformers\TermIdChecklistTransformer;
use WebTheory\Saveyour\Contracts\DataTransformerInterface;
use WebTheory\Saveyour\Contracts\FieldDataManagerInterface;
use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\FormFieldInterface;
use WebTheory\Saveyour\Controllers\AbstractField;
use WebTheory\Saveyour\Fields\Checklist;

class TermChecklist extends AbstractField implements FormFieldControllerInterface
{
    /**
     *
     */
    protected $taxonomy;

    /**
     *
     */
    protected $options;

    /**
     *
     */
    public function __construct(string $taxonomy, string $requestVar, array $options = [])
    {
        $this->taxonomy = $taxonomy;
        $this->options = $this->defineOptions($options);

        parent::__construct($requestVar);
    }

    /**
     *
     */
    protected function defineOptions(array $options)
    {
        return [
            'id' => $options['id'] ?? "wts--{$this->taxonomy}-checklist",
            'class' => $options['class'] ?? []
        ];
    }

    /**
     *
     */
    protected function createFormField(): ?FormFieldInterface
    {
        $options = $this->options;

        return (new Checklist)
            ->setChecklistItemProvider(new TaxonomyChecklistItems($this->taxonomy))
            ->setId($options['id'])
            ->setClasslist($options['class'])
            ->addClass('thing');
    }

    /**
     *
     */
    protected function createDataManager(): ?FieldDataManagerInterface
    {
        return new PostTermDataManager($this->taxonomy);
    }

    /**
     *
     */
    protected function createDataTransformer(): ?DataTransformerInterface
    {
        return new TermIdChecklistTransformer();
    }

    /**
     *
     */
    protected function defineFilters(): ?array
    {
        return ['sanitize_text_field'];
    }
}
