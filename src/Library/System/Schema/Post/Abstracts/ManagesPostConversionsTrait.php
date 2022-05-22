<?php

namespace Leonidas\Library\System\Schema\Post\Abstracts;

use Leonidas\Contracts\System\Schema\Post\PostConversionArchiveInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Schema\Post\PostConversionArchive;
use LogicException;
use WP_Post;

trait ManagesPostConversionsTrait
{
    protected PostConverterInterface $converter;

    protected PostConversionArchiveInterface $archive;

    protected function resolveArchive(?PostConversionArchiveInterface $archive): PostConversionArchiveInterface
    {
        if (!$archive) {
            return $this->defaultPostConversionArchive();
        } elseif (!$archive->hasRecords()) {
            return $archive;
        } else {
            throw new LogicException(
                'Instance of ' . PostConversionArchiveInterface::class . ' must be empty upon instantiation of ' . static::class . '.'
            );
        }
    }

    protected function defaultPostConversionArchive(): PostConversionArchiveInterface
    {
        return new PostConversionArchive();
    }

    protected function getConvertedPost(WP_Post $post): object
    {
        if (!$this->archive->hasRecordOf($post)) {
            $this->archive->archive($post, $this->converter->convert($post));
        }

        return $this->archive->getConversion($post);
    }

    protected function getRevertedPost(object $post): WP_Post
    {
        if (!$this->archive->hasRecordOf($post)) {
            $this->archive->archive($post, $this->converter->revert($post));
        }

        return $this->archive->getReversion($post);
    }
}
