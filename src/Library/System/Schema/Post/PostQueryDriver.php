<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\Post\PostConversionArchiveInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Schema\Post\Abstracts\ManagesPostConversionsTrait;
use WebTheory\Collection\Access\Abstracts\AbstractArrayDriver;
use WebTheory\Collection\Access\Abstracts\RejectsDuplicateObjectsTrait;
use WebTheory\Collection\Contracts\ArrayDriverInterface;
use WebTheory\Collection\Contracts\ObjectComparatorInterface;
use WP_Post;
use WP_Query;

class PostQueryDriver extends AbstractArrayDriver implements ArrayDriverInterface
{
    use ManagesPostConversionsTrait;
    use RejectsDuplicateObjectsTrait;

    protected WP_Query $query;

    protected ObjectComparatorInterface $comparator;

    public function __construct(
        WP_Query $query,
        PostConverterInterface $converter,
        ObjectComparatorInterface $comparator,
        ?PostConversionArchiveInterface $archive = null
    ) {
        $this->query = $query;
        $this->converter = $converter;
        $this->comparator = $comparator;
        $this->archive = $this->resolveArchive($archive);
    }

    public function fetch(array $array, $item)
    {
        return $this->getConvertedPost(parent::fetch($array, $item));
    }

    protected function append(array &$array, object $item, $offset = null): void
    {
        $array[] = $this->getRevertedPost($item);

        $this->query->post_count++;
    }

    protected function maybeRemoveItem(array &$array, $item): bool
    {
        $removed = parent::maybeRemoveItem($array, $item);

        if ($removed) {
            $this->query->post_count--;
        }

        return $removed;
    }

    protected function arrayContainsObject(array $array, object $object): bool
    {
        return parent::arrayContainsObject(
            $array,
            $this->getResolvedObject($object)
        );
    }

    protected function getResolvedObject(object $object): object
    {
        return !$object instanceof WP_Post
            ? $this->getRevertedPost($object)
            : $object;
    }
}
