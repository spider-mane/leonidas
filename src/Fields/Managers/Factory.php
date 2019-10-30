<?php

namespace WebTheory\Leonidas\Fields\Managers;

use WebTheory\Saveyour\Contracts\MultiFieldDataManagerFactoryInterface;
use WebTheory\Saveyour\DataManagerFactory;
use WebTheory\Leonidas\Fields\Managers\PostTermManager;
use WebTheory\Leonidas\Fields\Managers\PostMetaFieldManager;
use WebTheory\Leonidas\Fields\Managers\TermMetaDataManager;

class Factory extends DataManagerFactory implements MultiFieldDataManagerFactoryInterface
{
    public const NAMESPACES = [
        'webtheory.wordpress' => __NAMESPACE__
    ] + parent::NAMESPACES;

    public const MANAGERS = [
        'post_meta' => PostMetaFieldManager::class,
        'term_meta' => TermMetaDataManager::class,
        'post_term' => PostTermManager::class,
    ] + parent::MANAGERS;
}
