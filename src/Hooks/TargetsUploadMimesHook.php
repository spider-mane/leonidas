<?php

namespace Leonidas\Hooks;

use Closure;
use WP_User;

trait TargetsUploadMimesHook
{
    protected function targetUploadMimesHook()
    {
        add_filter(
            "upload_mimes",
            Closure::fromCallable([$this, 'filterUploadMimes']),
            $this->getUploadMimesPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getUploadMimesPriority(): int
    {
        return 10;
    }

    /**
     * Filters list of allowed mime types and file extensions.
     *
     * @param array $types
     * @param int|WP_User|null $user
     *
     * @return array
     */
    abstract protected function filterUploadMimes(array $types, $user): array;
}
