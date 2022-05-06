<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\ScriptLocalizationCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptLocalizationInterface;

class ScriptLocalizationCollection implements ScriptLocalizationCollectionInterface
{
    /**
     * @var ScriptLocalizationInterface[]
     */
    protected array $localizations = [];

    public function __construct(ScriptLocalizationInterface ...$localizations)
    {
        array_map([$this, 'addLocalization'], $localizations);
    }

    /**
     * @return ScriptLocalizationInterface[]
     */
    public function getLocalizations(): array
    {
        return $this->localizations;
    }

    public function addLocalization(ScriptLocalizationInterface $localization)
    {
        $this->localizations[$localization->getVariable()] = $localization;
    }

    public function getLocalization(string $localization): ScriptLocalizationInterface
    {
        return $this->localizations[$localization];
    }

    public function hasLocalization(string $localization): bool
    {
        return isset($this->localizations[$localization]);
    }

    public static function with(ScriptLocalizationInterface ...$localizations): ScriptLocalizationCollection
    {
        return new static(...$localizations);
    }

    public static function from(array $localizations): ScriptLocalizationCollection
    {
        return new static(...$localizations);
    }
}
