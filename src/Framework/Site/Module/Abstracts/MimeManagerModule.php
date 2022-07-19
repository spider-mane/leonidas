<?php

namespace Leonidas\Framework\Site\Module\Abstracts;

use Leonidas\Framework\Module\Abstracts\Module;
use Leonidas\Hooks\TargetsUploadMimesHook;
use WP_User;

abstract class MimeManagerModule extends Module
{
    use TargetsUploadMimesHook;

    public function hook(): void
    {
        $this->targetUploadMimesHook();
    }

    protected function filterUploadMimes(array $types, $user): array
    {
        $request = $this->getServerRequest()
            ->withAttribute('mime_types', $types)
            ->withAttribute('user', $this->resolveUser($user));

        return $types;
    }

    /**
     * @param int|WP_User|null $user
     */
    protected function resolveUser($user): ?WP_User
    {
        return $user && is_int($user) ? get_user_by('id', $user) : $user;
    }
}
