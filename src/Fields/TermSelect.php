<?php

namespace WebTheory\Leonidas\Fields;

use WebTheory\Leonidas\Fields\Formatters\TermSelectFormatter;
use WebTheory\Leonidas\Fields\Managers\PostTermDataManager;
use WebTheory\Leonidas\Fields\Selections\TaxonomySelectOptions;
use WebTheory\Saveyour\Contracts\DataFormatterInterface;
use WebTheory\Saveyour\Contracts\FieldDataManagerInterface;
use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\FormFieldInterface;
use WebTheory\Saveyour\Controllers\AbstractField;
use WebTheory\Saveyour\Fields\Select;

class TermSelect extends AbstractField implements FormFieldControllerInterface
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
            'id' => $options['id'] ?? "wts--{$this->taxonomy}-select",
            'class' => $options['class'] ?? [],
            'multiple' => $options['multiple'] ?? false
        ];
    }

    /**
     *
     */
    protected function defineFormField(): FormFieldInterface
    {
        $options = $this->options;

        return (new Select)
            ->setSelectionProvider(new TaxonomySelectOptions($this->taxonomy))
            ->setMultiple($options['multiple'])
            ->setId($options['id'])
            ->setClasslist($options['class']);
    }

    /**
     *
     */
    protected function defineDataManager(): ?FieldDataManagerInterface
    {
        return new PostTermDataManager($this->taxonomy);
    }

    /**
     *
     */
    protected function defineDataFormatter(): ?DataFormatterInterface
    {
        return new TermSelectFormatter();
    }

    /**
     *
     */
    protected function defineFilters(): ?array
    {
        return ['sanitize_text_field'];
    }
}
