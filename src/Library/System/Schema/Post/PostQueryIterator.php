<?php

namespace Leonidas\Library\System\Schema\Post;

use Countable;
use Iterator;
use Leonidas\Contracts\System\Schema\Post\PostConversionArchiveInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Schema\Post\Traits\ManagesPostConversionsTrait;
use WP_Query;

class PostQueryIterator implements Iterator, Countable
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

    protected function loopStarted(): bool
    {
        return $this->key() > -1;
    }

    protected function loopEnded(): bool
    {
        return $this->key() === $this->count() - 1;
    }

    public function current()
    {
        if (!$this->loopStarted()) {
            $this->query->the_post();
        }

        return $this->getConvertedPost($GLOBALS['post']);
    }

    public function next(): void
    {
        if (!$this->loopStarted()) {
            $this->query->the_post();
        }

        $this->query->the_post();

        if ($this->loopEnded()) {
            wp_reset_postdata();
        }
    }

    public function rewind(): void
    {
        $this->query->rewind_posts();
    }

    public function key()
    {
        return $this->query->current_post;
    }

    public function valid(): bool
    {
        return $this->query->have_posts();
    }

    public function count(): int
    {
        return count($this->query->posts);
    }

    public static function fromGlobal(
        PostConverterInterface $factory,
        ?PostConversionArchiveInterface $archive = null
    ): PostQueryIterator {
        return new static($GLOBALS['wp_query'], $factory, $archive);
    }
}
