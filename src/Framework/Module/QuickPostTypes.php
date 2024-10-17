<?php

namespace Leonidas\Framework\Module;

use Leonidas\Framework\Module\Abstracts\Module;
use Leonidas\Hooks\TargetsInitHook;

class QuickPostTypes extends Module
{
    use TargetsInitHook;

    public function hook(): void
    {
        $this->targetInitHook();
    }

    protected function doInitAction(): void
    {
        $this->registerPostTypes();
    }

    protected function registerPostTypes()
    {
        foreach ($this->postTypes() as $name => $args) {
            register_post_type($this->formatName($name), $args);
        }
    }

    protected function formatName(string $name): string
    {
        return $this->prefix($name, '_');
    }

    /**
     * @return array<string,array>
     */
    protected function postTypes(): array
    {
        return $this->getConfig('post_types');
    }
}
