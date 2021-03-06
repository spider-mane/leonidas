<?php

namespace WebTheory\Leonidas\Admin\Fields\Factory;

use WebTheory\Leonidas\Admin\Fields\Managers\PostMetaFieldManager;
use WebTheory\Leonidas\Admin\Fields\Managers\PostTermManager;
use WebTheory\Leonidas\Admin\Fields\Managers\TermMetaDataManager;
use WebTheory\Saveyour\Contracts\FieldDataManagerResolverFactoryInterface;
use WebTheory\Saveyour\Factories\DataManagerFactory;

class DataManager extends DataManagerFactory implements FieldDataManagerResolverFactoryInterface
{
    public const NAMESPACES = [
        'webtheory.leonidas' => __NAMESPACE__
    ] + parent::NAMESPACES;

    public const MANAGERS = [
        'post_meta' => PostMetaFieldManager::class,
        'term_meta' => TermMetaDataManager::class,
        'post_term' => PostTermManager::class,
    ] + parent::MANAGERS;
}
