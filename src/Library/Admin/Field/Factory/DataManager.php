<?php

namespace Leonidas\Library\Admin\Field\Factory;

use Leonidas\Library\Admin\Field\Data\PostMetaFieldManager;
use Leonidas\Library\Admin\Field\Data\PostTermDataManager;
use Leonidas\Library\Admin\Field\Data\PostTermManager;
use Leonidas\Library\Admin\Field\Data\TermMetaDataManager;
use WebTheory\Saveyour\Contracts\Factory\FieldDataManagerResolverFactoryInterface;
use WebTheory\Saveyour\Factory\DataManagerFactory;

class DataManager extends DataManagerFactory implements FieldDataManagerResolverFactoryInterface
{
    public const NAMESPACES = [
        'webtheory.leonidas' => __NAMESPACE__,
    ] + parent::NAMESPACES;

    public const MANAGERS = [
        'post_meta' => PostMetaFieldManager::class,
        'term_meta' => TermMetaDataManager::class,
        'post_term' => PostTermDataManager::class,
    ] + parent::MANAGERS;
}
