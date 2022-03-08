<?php

namespace Leonidas\Library\Admin\Page\SettingsField;

use Leonidas\Contracts\Admin\Components\SettingsFieldInterface;
use Leonidas\Contracts\Http\ServerRequestPolicyInterface;
use Leonidas\Library\Admin\Page\SettingsField\Traits\HasSettingsFieldDataTrait;
use Leonidas\Traits\CanBeRestrictedTrait;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Html\Html;
use WebTheory\Saveyour\Contracts\DataFormatterInterface;
use WebTheory\Saveyour\Contracts\FormFieldInterface;
use WebTheory\Saveyour\Fields\Text;

class SettingsField implements SettingsFieldInterface
{
    use CanBeRestrictedTrait;
    use HasSettingsFieldDataTrait;

    public function __construct(
        string $setting,
        string $id,
        string $title,
        string $page,
        string $section,
        ?string $inputId = null,
        ?array $args = null,
        ?FormFieldInterface $input = null,
        ?DataFormatterInterface $formatter = null,
        ?ServerRequestPolicyInterface $policy = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->page = $page;
        $this->section = $section;
        $this->setting = $setting;

        $this->inputId = $inputId ?? $this->id;

        $args && $this->args = $args;
        $input && $this->input = $input;
        $formatter && $this->formatter = $formatter;
        $policy && $this->policy = $policy;
    }

    public function renderComponent(ServerRequestInterface $request): string
    {
        $output = '';
        $settingData = $this->getSettingData();
        $value = get_option($this->getSetting(), $settingData['default'] ?? null);

        $output .= ($this->input ?? $this->getDefaultInput())
            ->setName($this->getSetting())
            ->setValue($this->formatValue($value))
            ->setId($this->getInputId())
            ->toHtml() . "\n";

        if ($description = $settingData['description'] ?? false) {
            $output .= $this->renderDescription($description) . "\n";
        }

        return $output;
    }

    protected function getSettingData(): array
    {
        return get_registered_settings()[$this->getSetting()];
    }

    protected function getDefaultInput(): FormFieldInterface
    {
        $input = new Text();
        $input->addClass('regular-text');

        return $input;
    }

    protected function renderDescription($description)
    {
        $this->args['description_attr']['class'][] = 'description';

        return Html::tag('p', [$this->args['description_attr']], $description);
    }

    protected function formatValue($value)
    {
        return $this->formatter ? $this->formatter->formatData($value) : $value;
    }
}
