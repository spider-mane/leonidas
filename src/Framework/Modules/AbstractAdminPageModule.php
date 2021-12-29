<?php

namespace Leonidas\Framework\Modules;

use DateInterval;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\Traits\ProcessesSettingsTrait;
use Leonidas\Traits\Hooks\TargetsAdminNoticesHook;
use Leonidas\Traits\Hooks\TargetsWpRedirectHook;

abstract class AbstractAdminPageModule extends AbstractInfoAdminPageModule implements ModuleInterface
{
    use TargetsAdminNoticesHook;
    use TargetsWpRedirectHook;
    use ProcessesSettingsTrait;

    protected string $cacheKey;

    /**
     * @var null|int|DateInterval
     */
    protected $cacheTtl = HOUR_IN_SECONDS;

    public function hook(): void
    {
        parent::hook();
        ProcessesSettingsTrait::hook();
    }
}
