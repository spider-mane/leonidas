<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Ui\Asset\ImageSizeCollectionInterface;
use Leonidas\Framework\Module\Abstracts\Traits\MustBeInitiatedTrait;
use Leonidas\Hooks\TargetsAfterSetupThemeHook;
use Leonidas\Hooks\TargetsImageSizeNamesChooseHook;

abstract class ImageSizeProviderModule extends Module implements ModuleInterface
{
    use TargetsAfterSetupThemeHook;
    use TargetsImageSizeNamesChooseHook;
    use MustBeInitiatedTrait;

    protected ImageSizeCollectionInterface $definitions;

    protected function getDefinitions(): ImageSizeCollectionInterface
    {
        return $this->definitions;
    }

    public function hook(): void
    {
        $this->targetAfterSetupThemeHook();
        $this->targetImageSizeNamesChooseHook();
    }

    protected function doAfterSetupThemeAction(): void
    {
        $this->initWith('definitions');

        foreach ($this->getDefinitions()->getSizes() as $size) {
            add_image_size(
                $size->getName(),
                $size->getWidth(),
                $size->getHeight(),
                $size->getCrop()
            );
        }
    }

    protected function filterImageSizeNamesChoose(array $sizeNames): array
    {
        if (!$this->isInitiated()) {
            return $sizeNames;
        }

        foreach ($this->getDefinitions()->getSizes() as $size) {
            $sizeNames[$size->getName()] = $size->getLabel();
        }

        return $sizeNames;
    }

    abstract protected function definitions(): ImageSizeCollectionInterface;
}
