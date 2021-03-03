<?php

namespace WebTheory\Leonidas\Admin\Contracts;

interface MetaboxInterface extends AdminComponentInterface
{
    public function getId(): string;

    public function getTitle(): string;

    public function getScreen();

    public function getContext(): string;

    public function getPriority(): string;

    public function getCallBackArgs(): ?array;
}
