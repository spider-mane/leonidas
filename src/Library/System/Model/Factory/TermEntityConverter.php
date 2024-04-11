<?php

namespace Leonidas\Library\System\Model\Factory;

use Leonidas\Contracts\System\Schema\Term\TermConverterInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Schema\Exceptions\UnexpectedEntityException;
use WP_Term;

class TermEntityConverter implements TermConverterInterface
{
    public function __construct(
        protected string $type,
        protected string $class,
        protected string $taxonomy,
        protected AutoInvokerInterface $invoker
    ) {
        //
    }

    public function convert(WP_Term $post): object
    {
        return new $this->class($post, $this->invoker);
    }

    public function revert(object $entity): WP_Term
    {
        if ($entity instanceof $this->type) {
            return get_term($entity->getId(), $this->taxonomy);
        }

        throw new UnexpectedEntityException(
            $this->type,
            $entity,
            __METHOD__
        );
    }
}
