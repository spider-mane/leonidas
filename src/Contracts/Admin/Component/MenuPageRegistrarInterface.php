<?php

namespace Leonidas\Contracts\Admin\Component;

interface MenuPageRegistrarInterface
{
    public function registerOne(MenuPageInterface $page);
}
