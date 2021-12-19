<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Ui\Asset\ImageSizeCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ImageSizeInterface;
use Leonidas\Framework\Modules\Traits\MustBeInitiatedTrait;
use Leonidas\Traits\Hooks\TargetsAfterSetupThemeHook;
use Leonidas\Traits\Hooks\TargetsImageSizeNamesChooseHook;

abstract class AbstractImageSizeProviderModule extends AbstractModule
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

    protected function init()
    {
        $this->definitions = $this->definitions();
    }

    protected function doAfterSetupThemeAction(): void
    {
        $this->maybeInit();

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
            return;
        }

        foreach ($this->getDefinitions()->getSizes() as $size) {
            $sizeNames[$size->getName()] = $size->getLabel();
        }

        return $sizeNames;
    }

    abstract protected function definitions(): ImageSizeCollectionInterface;
}
