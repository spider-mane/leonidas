<?php

namespace Leonidas\Contracts\System\Model;

interface MutableTitledInterface extends TitledInterface
{
    /**
     * @return $this
     */
    public function setTitle(string $title): static;
}
