<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\Post\PostConversionArchiveInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Schema\Post\Abstracts\ManagesPostConversionsTrait;
use WebTheory\Collection\Access\Abstracts\AbstractArrayDriver;
use WebTheory\Collection\Access\Abstracts\RejectsDuplicateObjectsTrait;
use WebTheory\Collection\Contracts\ArrayDriverInterface;
use WebTheory\Collection\Contracts\ObjectComparatorInterface;
use WP_Query;

class PostQueryDriver extends AbstractArrayDriver implements ArrayDriverInterface
{
    use ManagesPostConversionsTrait;
    use RejectsDuplicateObjectsTrait;

    protected WP_Query $query;

    public function __construct(
        WP_Query $query,
        PostConverterInterface $converter,
        ObjectComparatorInterface $comparator,
        ?PostConversionArchiveInterface $archive = null
    ) {
        $this->query = $query;
        $this->converter = $converter;
        $this->objectComparator = $comparator;
        $this->conversionArchive = $archive ?? new PostConversionArchive();
    }

    protected function append(array &$array, object $item): void
    {
        $array[] = $item;
        $this->query->posts[] = $this->getRevertedPost($item);

        $this->query->post_count++;
    }

    protected function maybeRemoveItem(array &$array, $item): bool
    {
        $object = $array[$item] ?? null;
        $removed = parent::maybeRemoveItem($array, $item);

        if ($removed) {
            $this->removeCorrespondingQueryPost($object);
        }

        return $removed;
    }

    protected function deleteObjectIfLocated(array &$array, object $object): bool
    {
        $removed = parent::deleteObjectIfLocated($array, $object);

        if ($removed) {
            $this->removeCorrespondingQueryPost($object);
        }

        return $removed;
    }

    protected function removeCorrespondingQueryPost(object $item): void
    {
        $post = $this->getRevertedPost($item);
        $index = array_search($post, $this->query->posts);

        if (false !== $index) {
            unset($this->query->posts[$index]);
            $this->query->post_count--;
        }
    }
}
