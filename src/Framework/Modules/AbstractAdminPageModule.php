<?php

namespace Leonidas\Framework\Modules;

use DateInterval;
use GuzzleHttp\Psr7\Request;
use Leonidas\Contracts\Admin\Components\AdminPageInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\Traits\ProcessesSettingsTrait;
use Leonidas\Traits\Hooks\TargetsAdminMenuHook;
use Leonidas\Traits\Hooks\TargetsAdminNoticesHook;
use Leonidas\Traits\Hooks\TargetsAdminTitleHook;
use Leonidas\Traits\Hooks\TargetsWpRedirectHook;
use Psr\SimpleCache\CacheInterface;
use Stringable;

abstract class AbstractAdminPageModule extends AbstractInfoAdminPageModule implements ModuleInterface
{
    use TargetsAdminNoticesHook;
    use TargetsWpRedirectHook;
    use ProcessesSettingsTrait;

    protected string|Stringable $cacheKey;

    protected null|int|DateInterval $cacheTtl = HOUR_IN_SECONDS;

    public function hook(): void
    {
        parent::hook();
        ProcessesSettingsTrait::hook();
    }
}
