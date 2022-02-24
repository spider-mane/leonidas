<?php

namespace Leonidas\Library\Admin\Page\SettingsField;

use Leonidas\Contracts\Admin\Components\SettingsFieldCollectionInterface;
use Leonidas\Contracts\Admin\Components\SettingsFieldInterface;
use Leonidas\Contracts\Admin\Components\SettingsFieldLoaderInterface;
use Psr\Http\Message\ServerRequestInterface;

class SettingsFieldLoader implements SettingsFieldLoaderInterface
{
    /**
     * @var callable
     */
    protected $outputHandler;

    public function __construct(callable $outputHandler)
    {
        $this->outputHandler = $outputHandler;
    }

    public function getOutputHandler(): callable
    {
        return $this->outputHandler;
    }

    public function registerOne(SettingsFieldInterface $field, ServerRequestInterface $request)
    {
        if ($field->shouldBeRendered($request)) {
            add_settings_field(
                $field->getId(),
                $field->getTitle(),
                $this->getOutputHandler(),
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
