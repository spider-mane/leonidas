<?php

namespace WebTheory\Leonidas\Core\Contracts;

interface ListenerInterface
{
    /**
     *
     */
    public function getHookTag(): string;

    /**
     *
     */
    public function getFeatureGroup(): string;

    /**
     *
     */
    public function getCallback(): callable;

    /**
     *
     */
    public function getPriority(): int;

    /**
     *
     */
    public function acceptedArgs(): int;
}
