<?php

namespace WebTheory\Leonidas\Contracts\Ui;

interface AssetInterface
{

    /**
     * @return string
     */
    public function getHandle(): string;

    /**
     * @return string|bool
     */
    public function getSrc();

    /**
     * @return string[]
     */
    public function getDeps(): ?array;

    /**
     * @return string|bool|null
     */
    public function getVersion();
}
