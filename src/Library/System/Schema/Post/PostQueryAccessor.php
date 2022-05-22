<?php

namespace Leonidas\Library\System\Schema\Post;

use ArrayAccess;
use Countable;
use Leonidas\Contracts\System\Schema\Post\PostConversionArchiveInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Schema\Post\Abstracts\ManagesPostConversionsTrait;
use WP_Query;

class PostQueryAccessor implements ArrayAccess, Countable
{
    use ManagesPostConversionsTrait;

    protected WP_Query $query;

    public function __construct(
        WP_Query $query,
        PostConverterInterface $converter,
        ?PostConversionArchiveInterface $archive = null
    ) {
        $this->query = $query;
        $this->converter = $converter;
        $this->archive = $this->resolveArchive($archive);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->query->posts[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->getConvertedPost($this->query->posts[$offset]);
    }

    public function offsetSet($offset, $value): void
    {
        $this->query->posts[$offset] = $this->getRevertedPost($value);
    }

    public function offsetUnset($offset): void
    {
        unset($this->query->posts[$offset]);
    }

    public function count(): int
    {
        return count($this->query->posts);
    }
}
