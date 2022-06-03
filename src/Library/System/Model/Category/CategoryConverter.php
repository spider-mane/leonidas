<?php

namespace Leonidas\Library\System\Model\Category;

use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Schema\Term\TermConverterInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelConverter;
use Leonidas\Library\System\Schema\Exceptions\UnexpectedEntityException;
use WP_Term;

class CategoryConverter extends AbstractModelConverter implements TermConverterInterface
{
    public function convert(WP_Term $term): CategoryInterface
    {
        return new Category($term, $this->autoInvoker);
    }

    public function revert(object $entity): WP_Term
    {
        if ($entity instanceof CategoryInterface) {
            return get_term($entity->getId(), 'category');
        }

        throw new UnexpectedEntityException(
            CategoryInterface::class,
            $entity,
            __METHOD__
        );
    }
}
