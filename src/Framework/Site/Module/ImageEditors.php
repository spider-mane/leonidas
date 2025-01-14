<?php

namespace Leonidas\Framework\Site\Module;

use Leonidas\Framework\Module\Abstracts\Module;
use Leonidas\Hooks\TargetsWpImageEditorsHook;
use WP_Image_Editor;

class ImageEditors extends Module
{
    use TargetsWpImageEditorsHook;

    public function hook(): void
    {
        $this->targetWpImageEditorsHook();
    }

    protected function defineWpImageEditorsPriority(): int
    {
        return 10;
    }

    protected function filterWpImageEditors(array $imageEditors): array
    {
        return $this->shouldReplaceEditors()
            ? $this->editors()
            : array_merge($this->editors(), $imageEditors);
    }

    protected function shouldReplaceEditors(): bool
    {
        return $this->getConfig('modules.image_editors.replace', false);
    }

    /**
     * @return WP_Image_Editor[]
     */
    protected function editors(): array
    {
        return $this->getConfig('images.editors', []);
    }
}
