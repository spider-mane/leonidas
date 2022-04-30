<?php

namespace Leonidas\Library\System\Model\Abstracts;

use IteratorAggregate;
use Leonidas\Contracts\Collection\ObjectCollectionInterface;

abstract class AbstractModelCollection implements ObjectCollectionInterface, IteratorAggregate
{
    use KernelPoweredModelCollectionTrait;
}
