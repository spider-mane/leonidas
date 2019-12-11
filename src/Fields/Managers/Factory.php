<?php

namespace WebTheory\Leonidas\Fields\Managers;

use WebTheory\Leonidas\Fields\Managers\PostMetaFieldManager;
use WebTheory\Leonidas\Fields\Managers\PostTermManager;
use WebTheory\Leonidas\Fields\Managers\TermMetaDataManager;
use WebTheory\Saveyour\Contracts\FieldDataManagerResolverFactoryInterface;
use WebTheory\Saveyour\Factories\DataManagerFactory;

class Factory extends DataManagerFactory implements FieldDataManagerResolverFactoryInterface
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
