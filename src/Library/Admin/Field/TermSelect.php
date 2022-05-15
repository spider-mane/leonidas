<?php

namespace Leonidas\Library\Admin\Field;

use Leonidas\Library\Admin\Field\Data\PostTermDataManager;
use Leonidas\Library\Admin\Field\Formatting\TermsToIdsDataFormatter;
use Leonidas\Library\Admin\Field\Selection\TaxonomySelectOptions;
use WebTheory\Saveyour\Contracts\Controller\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\Data\FieldDataManagerInterface;
use WebTheory\Saveyour\Contracts\Field\FormFieldInterface;
use WebTheory\Saveyour\Contracts\Field\Selection\OptionsProviderInterface;
use WebTheory\Saveyour\Contracts\Formatting\DataFormatterInterface;
use WebTheory\Saveyour\Controller\Abstracts\AbstractField;
use WebTheory\Saveyour\Field\Type\Select;

class TermSelect extends AbstractField implements FormFieldControllerInterface
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
            'id' => $options['id'] ?? "wts--{$this->taxonomy}-select",
            'class' => $options['class'] ?? [],
            'multiple' => $options['multiple'] ?? false,
        ];
    }

    protected function defineFormField(): FormFieldInterface
    {
        $options = $this->options;

        return (new Select())
            ->setSelectionProvider($this->createSelection())
            ->setMultiple($options['multiple'])
            ->setId($options['id'])
            ->setClasslist($options['class']);
    }

    protected function createSelection(): OptionsProviderInterface
    {
        return new TaxonomySelectOptions($this->taxonomy);
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
