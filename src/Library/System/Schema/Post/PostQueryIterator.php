<?php

namespace Leonidas\Library\System\Schema\Post;

use Countable;
use Iterator;
use Leonidas\Contracts\System\Schema\Post\PostConversionArchiveInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Schema\Post\Abstracts\ManagesPostConversionsTrait;
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
        $this->conversionArchive = $archive;
    }

    public function current(): object
    {
        $this->maybeStartLoop();

        return $this->getConvertedPost($GLOBALS['post']);
    }

    public function key(): int
    {
        return $this->query->current_post;
    }

    public function next(): void
    {
        $this->maybeStartLoop();

        if (!$this->loopEnded()) {
            $this->nextPost();
        }
    }

    public function rewind(): void
    {
        $this->query->rewind_posts();
    }

    public function valid(): bool
    {
        if (!$valid = $this->query->have_posts()) {
            $this->resetData();
        }

        return $valid;
    }

    public function count(): int
    {
        return count($this->query->posts);
    }

    protected function maybeStartLoop(): void
    {
        if (!$this->loopStarted()) {
            $this->nextPost();
        }
    }

    protected function loopStarted(): bool
    {
        return $this->key() > -1;
    }

    protected function loopEnded(): bool
    {
        return $this->key() === $this->count() - 1;
    }

    protected function nextPost(): void
    {
        $this->query->the_post();
    }

    protected function resetData(): void
    {
        wp_reset_postdata();
    }
}
