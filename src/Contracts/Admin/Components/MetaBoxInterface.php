<?php

namespace WebTheory\Leonidas\Contracts\Admin\Components;

use WebTheory\Leonidas\Admin\Contracts\AdminComponentInterface;

interface MetaboxInterface extends AdminComponentInterface
{
    public function getId(): string;

    public function getTitle(): string;

    public function getScreen();

    public function getContext(): string;

    public function getPriority(): string;

    public function getCallBackArgs(): ?array;
}