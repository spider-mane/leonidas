<?php

namespace Leonidas\Library\Admin\Page\SettingsSection;

use Leonidas\Contracts\Admin\Components\SettingsSectionCollectionInterface;
use Leonidas\Contracts\Admin\Components\SettingsSectionInterface;
use Leonidas\Contracts\Admin\Components\SettingsSectionLoaderInterface;
use Psr\Http\Message\ServerRequestInterface;

class SettingsSectionLoader implements SettingsSectionLoaderInterface
{
    /**
     * @var callable
     */
    protected $outputLoader;

    public function __construct(callable $outputLoader)
    {
        $this->outputLoader = $outputLoader;
    }

    public function getOutputLoader(): callable
    {
        return $this->outputLoader;
    }

    public function registerOne(SettingsSectionInterface $section, ServerRequestInterface $request)
    {
        if ($section->shouldBeRendered($request)) {
            add_settings_section(
                $section->getId(),
                $section->getTitle(),
                $this->getOutputLoader(),
                $section->getPage()
            );
        }
    }

    public function registerMany(SettingsSectionCollectionInterface $sections, ServerRequestInterface $request)
    {
        foreach ($sections->all() as $section) {
            $this->registerOne($section, $request);
        }
    }
}
