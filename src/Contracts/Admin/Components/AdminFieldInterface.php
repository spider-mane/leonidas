<?php

namespace WebTheory\Leonidas\Contracts\Admin\Components;

interface AdminFieldInterface extends AdminComponentInterface
{
    /**
     *
     */
    public function getLabel(): string;

    /**
     *
     */
    public function getDescription(): string;
}
