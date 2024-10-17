<?php

namespace Leonidas\Contracts\System\Configuration\PostType;

use Leonidas\Contracts\System\Configuration\ModelRestConfigInterface;

interface PostTypeRestConfigInterface extends ModelRestConfigInterface
{
    public function getAutosaveRestControllerClass(): null|string|bool;

    public function getRevisionsRestControllerClass(): null|string|bool;

    public function allowsLateRouteRegistration(): ?bool;
}
