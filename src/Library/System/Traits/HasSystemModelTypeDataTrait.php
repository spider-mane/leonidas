<?php

namespace Leonidas\Library\System\Traits;

trait HasSystemModelTypeDataTrait
{
    protected string $name;

    protected string $singularLabel;

    protected string $pluralLabel;

    protected string $description;

    protected array $capabilities;

    /**
     * @var bool|array
     */
    protected $rewrite;

    protected array $props;

    protected array $labels;

    protected array $options;

    public function getName(): string
    {
        return $this->name;
    }

    public function getPluralLabel(): string
    {
        return $this->pluralLabel;
    }

    public function getSingularLabel(): string
    {
        return $this->singularLabel;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCapabilities(): array
    {
        return $this->capabilities;
    }

    /**
     * @return bool|string
     */
    public function getRewrite()
    {
        return $this->rewrite;
    }

    public function getProps(): array
    {
        return $this->props;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getLabels()
    {
        return $this->labels;
    }
}
