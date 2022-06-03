<?php

namespace Leonidas\Library\System\Model\Tag;

use Leonidas\Contracts\System\Model\Tag\TagInterface;
use Leonidas\Contracts\System\Schema\Term\TermConverterInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelConverter;
use Leonidas\Library\System\Schema\Exceptions\UnexpectedEntityException;
use WP_Term;

class TagConverter extends AbstractModelConverter implements TermConverterInterface
{
    public function convert(WP_Term $term): Tag
    {
        return new Tag($term, $this->autoInvoker);
    }

    public function revert(object $entity): WP_Term
    {
        if ($entity instanceof TagInterface) {
            return get_term($entity->getId(), 'post_tag');
        }

        throw new UnexpectedEntityException(
            TagInterface::class,
            $entity,
            __METHOD__
        );
    }
}
