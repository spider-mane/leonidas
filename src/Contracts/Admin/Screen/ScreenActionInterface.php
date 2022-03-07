<?php

namespace Leonidas\Contracts\Admin\Screen;

interface ScreenActionInterface
{
    public function getScreens(): array;

    public function getScreenMap(): array;

    public function getAjaxActions(): array;

    public function doScreenAction(): void;
}
