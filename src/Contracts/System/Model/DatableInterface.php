<?php

namespace Leonidas\Contracts\System\Model;

use DateTimeInterface;

interface DatableInterface
{
    public function getDate(): DateTimeInterface;

    public function getDateGmt(): DateTimeInterface;

    public function getDateModified(): DateTimeInterface;

    public function getDateModifiedGmt(): DateTimeInterface;
}
