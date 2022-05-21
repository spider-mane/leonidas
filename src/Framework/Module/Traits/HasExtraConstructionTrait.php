<?php

namespace Leonidas\Framework\Module\Traits;

use Leonidas\Contracts\Extension\WpExtensionInterface;

trait HasExtraConstructionTrait
{
    public function __construct(WpExtensionInterface $extension)
    {
        $this->beforeConstruction();
        parent::__construct($extension);
        $this->afterConstruction();
    }

    protected function beforeConstruction(): void
    {
        //
    }

    protected function afterConstruction(): void
    {
        //
    }
}
