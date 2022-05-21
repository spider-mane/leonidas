<?php

namespace Leonidas\Library\Core\Abstracts;

use IteratorAggregate;
use Leonidas\Contracts\Collection\ObjectCollectionInterface;

abstract class AbstractObjectCollection implements ObjectCollectionInterface, IteratorAggregate
{
    use PoweredByCollectionKernelTrait;
}
