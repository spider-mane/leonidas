<?php

namespace Leonidas\Contracts\Ui;

interface ViewInterface
{
    public function render(array $data): string;
}
