<?php

namespace Leonidas\Contracts\System\Model;

use DateTimeInterface;

interface DatableInterface
{
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    public function getDate(): DateTimeInterface;

    public function getDateGmt(): DateTimeInterface;

    public function getDateModified(): DateTimeInterface;

    public function getDateModifiedGmt(): DateTimeInterface;
}
