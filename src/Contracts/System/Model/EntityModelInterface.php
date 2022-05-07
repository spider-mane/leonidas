<?php

namespace Leonidas\Contracts\System\Model;

interface EntityModelInterface
{
    public function getId(): int;

    public function getCore(): object;
}
