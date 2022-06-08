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

    protected PostConversionArchiveInterface $conversionArchive;

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

    protected function convertPosts(WP_Post ...$posts): array
    {
        return array_map([$this, 'getConvertedPost'], $posts);
    }

    protected function getConvertedPost(WP_Post $post): object
    {
        if (!$this->conversionArchive->hasRecordOf($post)) {
            $this->conversionArchive->archive($post, $this->converter->convert($post));
        }

        return $this->conversionArchive->getConversion($post);
    }

    protected function revertPosts(object ...$models): array
    {
        return array_map([$this, 'getRevertedPost'], $models);
    }

    protected function getRevertedPost(object $model): WP_Post
    {
        if (!$this->conversionArchive->hasRecordOf($model)) {
            $this->conversionArchive->archive($model, $this->converter->revert($model));
        }

        return $this->conversionArchive->getReversion($model);
    }
}
