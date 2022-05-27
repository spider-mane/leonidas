<?php

namespace Leonidas\Framework\Abstracts;

use Leonidas\Contracts\Localization\LocalizerInterface;
use Leonidas\Library\Core\Localization\Localizer;

trait TranslatesTextTrait
{
    use UtilizesExtensionTrait;

    protected LocalizerInterface $localizer;

    protected function translate(string $text): string
    {
        return $this->localizer->translate($text);
    }

    protected function getLocalizer(): LocalizerInterface
    {
        return $this->localizer;
    }

    protected function localizer(): LocalizerInterface
    {
        $service = LocalizerInterface::class;

        return $this->hasService($service)
            ? $this->getService($service)
            : new Localizer($this->getExtension()->getSlug());
    }
}
