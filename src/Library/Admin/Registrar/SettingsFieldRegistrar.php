<?php

namespace Leonidas\Library\Admin\Registrar;

use Leonidas\Contracts\Admin\Callback\SettingsFieldCallbackProviderInterface;
use Leonidas\Contracts\Admin\Component\SettingsField\SettingsFieldCollectionInterface;
use Leonidas\Contracts\Admin\Component\SettingsField\SettingsFieldInterface;
use Leonidas\Contracts\Admin\Registrar\SettingsFieldRegistrarInterface;
use Psr\Http\Message\ServerRequestInterface;

class SettingsFieldRegistrar implements SettingsFieldRegistrarInterface
{
    public function __construct(protected SettingsFieldCallbackProviderInterface $callbackProvider)
    {
        //
    }

    public function registerOne(SettingsFieldInterface $field, ServerRequestInterface $request)
    {
        if ($field->shouldBeRendered($request)) {
            add_settings_field(
                $field->getId(),
                $field->getTitle(),
                $this->getRenderingCallback($field, $request),
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

    protected function getRenderingCallback(SettingsFieldInterface $field, ServerRequestInterface $request): callable
    {
        return $this->callbackProvider->getRenderingCallback($field, $request);
    }
}
