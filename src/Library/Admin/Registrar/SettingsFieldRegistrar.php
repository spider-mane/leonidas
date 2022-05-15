<?php

namespace Leonidas\Library\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\SettingsFieldCollectionInterface;
use Leonidas\Contracts\Admin\Component\SettingsFieldInterface;
use Leonidas\Contracts\Admin\Component\SettingsFieldRegistrarInterface;
use Leonidas\Library\Admin\Registrar\Abstracts\AbstractRegistrar;
use Psr\Http\Message\ServerRequestInterface;

class SettingsFieldRegistrar extends AbstractRegistrar implements SettingsFieldRegistrarInterface
{
    public function registerOne(SettingsFieldInterface $field, ServerRequestInterface $request)
    {
        if ($field->shouldBeRendered($request)) {
            add_settings_field(
                $field->getId(),
                $field->getTitle(),
                $this->getOutputLoader(),
                $field->getPage(),
                $field->getSection(),
                $this->getFieldArgs($field)
            );
        }
    }

    public function registerMany(SettingsFieldCollectionInterface $fields, ServerRequestInterface $request)
    {
        foreach ($fields->all() as $field) {
            $this->registerOne($field, $request);
        }
    }

    protected function getFieldArgs(SettingsFieldInterface $field): array
    {
        return [
            '@base' => $field,
            'label_for' => $field->getInputId(),
        ] + $field->getArgs();
    }
}
