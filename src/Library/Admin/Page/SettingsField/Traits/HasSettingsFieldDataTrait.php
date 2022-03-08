<?php

namespace Leonidas\Library\Admin\Page\SettingsField\Traits;

use Leonidas\Contracts\Http\ServerRequestPolicyInterface;
use WebTheory\Saveyour\Contracts\DataFormatterInterface;
use WebTheory\Saveyour\Contracts\FormFieldInterface;

trait HasSettingsFieldDataTrait
{
    protected string $setting;

    protected string $id;

    protected string $title;

    protected string $page;

    protected string $section;

    protected string $inputId;

    protected array $args = [];

    protected ?FormFieldInterface $input = null;

    protected ?DataFormatterInterface $formatter = null;

    protected ?ServerRequestPolicyInterface $policy = null;

    public function getSetting(): string
    {
        return $this->setting;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPage(): string
    {
        return $this->page;
    }

    public function getSection(): string
    {
        return $this->section;
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    public function getInputId(): string
    {
        return $this->inputId;
    }

    public function getInput(): ?FormFieldInterface
    {
        return $this->input;
    }

    public function getFormatter(): ?DataFormatterInterface
    {
        return $this->formatter;
    }
}
