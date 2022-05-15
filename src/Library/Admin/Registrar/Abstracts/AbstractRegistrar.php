<?php

namespace Leonidas\Library\Admin\Registrar\Abstracts;

abstract class AbstractRegistrar
{
    /**
     * @var callable
     */
    protected $outputLoader;

    public function __construct(callable $outputLoader)
    {
        $this->outputLoader = $outputLoader;
    }

    protected function getOutputLoader(): callable
    {
        return $this->outputLoader;
    }
}
