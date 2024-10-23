<?php

namespace Leonidas\Contracts\System\Configuration;

interface ModelRestConfigInterface
{
    public function isAllowedInRest(): ?bool;

    public function getRestBase(): null|bool|string;

    public function getRestNamespace(): null|bool|string;

    public function getRestControllerClass(): null|bool|string;
}
