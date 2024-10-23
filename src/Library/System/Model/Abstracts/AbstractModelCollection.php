<?php

namespace Leonidas\Library\System\Model\Abstracts;

use IteratorAggregate;
use Leonidas\Contracts\Collection\ObjectCollectionInterface;

/**
 * @template T
 * @implements ObjectCollectionInterface<T>
 */
abstract class AbstractModelCollection implements ObjectCollectionInterface, IteratorAggregate
{
    use KernelPoweredModelCollectionTrait;
}
