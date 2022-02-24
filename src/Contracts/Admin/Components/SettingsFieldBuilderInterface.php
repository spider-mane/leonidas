<?php

namespace Leonidas\Contracts\Admin\Components;

interface SettingsFieldBuilderInterface
{
    public function id(string $id);

    public function title(string $title);

    public function page(string $page);

    public function section(string $section);

    public function inputId(string $inputId);

    public function args(array $args);

    public function get(): SettingsFieldInterface;
}
