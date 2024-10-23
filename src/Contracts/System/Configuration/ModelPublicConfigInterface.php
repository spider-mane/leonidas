<?php

namespace Leonidas\Contracts\System\Configuration;

interface ModelPublicConfigInterface
{
    public function isPubliclyQueryable(): ?bool;

    public function getRewrite(): null|bool|array;

    public function getQueryVar(): null|bool|string;
}
