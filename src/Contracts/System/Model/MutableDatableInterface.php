<?php

namespace Leonidas\Contracts\System\Model;

use DateTimeInterface;

interface MutableDatableInterface extends DatableInterface
{
    public function setDate(DateTimeInterface $date): self;

    public function setDateGmt(DateTimeInterface $date): self;

    public function setDateModified(DateTimeInterface $date): self;

    public function setDateModifiedGmt(DateTimeInterface $date): self;
}
