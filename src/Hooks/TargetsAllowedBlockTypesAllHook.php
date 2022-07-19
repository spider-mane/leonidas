<?php

namespace Leonidas\Hooks;

use Closure;
use WP_Block_Editor_Context;

trait TargetsAllowedBlockTypesAllHook
{
    protected function targetAllowedBlockTypesAllHook()
    {
        add_filter(
            "allowed_block_types_all",
            Closure::fromCallable([$this, 'filterAllowedBlockTypesAll']),
            $this->getAllowedBlockTypesAllPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getAllowedBlockTypesAllPriority(): int
    {
        return HOOK_DEFAULT_PRIORITY;
    }

    /**
     * Filters the allowed block types for all editor types.
     *
     * @param bool|array<string> $allowedBlockTypes
     * @param WP_Block_Editor_Context $blockEditorContext
     *
     * @return bool|array<string>
     */
    abstract protected function filterAllowedBlockTypesAll($allowedBlockTypes, WP_Block_Editor_Context $blockEditorContext);
}
