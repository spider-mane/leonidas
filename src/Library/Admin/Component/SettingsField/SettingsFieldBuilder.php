<?php

namespace Leonidas\Library\Admin\Component\SettingsField;

use Leonidas\Contracts\Admin\Component\SettingsField\SettingsFieldBuilderInterface;
use Leonidas\Contracts\Admin\Component\SettingsField\SettingsFieldInterface;
use Leonidas\Library\Admin\Component\SettingsField\Abstracts\HasSettingsFieldDataTrait;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;
use WebTheory\Saveyour\Contracts\Field\FormFieldInterface;
use WebTheory\Saveyour\Contracts\Formatting\DataFormatterInterface;

class SettingsFieldBuilder implements SettingsFieldBuilderInterface
{
    use HasSettingsFieldDataTrait;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function setting(string $setting)
    {
        $this->setting = $setting;
    }

    public function id(string $id)
    {
        $this->id = $id;
    }

    public function title(string $title)
    {
        $this->title = $title;
    }

    public function page(string $page)
    {
        $this->page = $page;
    }

    public function section(string $section)
    {
        $this->section = $section;
    }

    public function inputId(string $inputId)
    {
        $this->inputId = $inputId;
    }

    public function args(array $args)
    {
        $this->args = $args;
    }

    public function formatter(DataFormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }

    public function input(FormFieldInterface $input)
    {
        $this->input = $input;
    }

    public function policy(ServerRequestPolicyInterface $policy)
    {
        $this->policy = $policy;
    }

    public function getPolicy(): ?ServerRequestPolicyInterface
    {
        return $this->policy;
    }

    public function get(): SettingsFieldInterface
    {
        return new SettingsField(
            $this->getSetting(),
            $this->getId(),
            $this->getTitle(),
            $this->getPage(),
            $this->getSection(),
            $this->getInputId(),
            $this->getArgs(),
            $this->getInput(),
            $this->getFormatter(),
            $this->getPolicy()
        );
    }
}
