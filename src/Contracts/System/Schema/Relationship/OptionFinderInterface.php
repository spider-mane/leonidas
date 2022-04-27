<?php

namespace Leonidas\Contracts\System\Schema\Relationship;

interface OptionFinderInterface
{
    /**
     * @return mixed
     */
    public function get(string $option);
}
