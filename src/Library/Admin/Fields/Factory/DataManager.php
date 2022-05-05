<?php

namespace Leonidas\Library\Admin\Fields\Factory;

use Leonidas\Library\Admin\Fields\Managers\PostMetaFieldManager;
use Leonidas\Library\Admin\Fields\Managers\PostTermManager;
use Leonidas\Library\Admin\Fields\Managers\TermMetaDataManager;
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
        'post_term' => PostTermManager::class,
    ] + parent::MANAGERS;
}
