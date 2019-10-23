<?php

namespace Backalley\WordPress\Fields\Managers;

use Backalley\Form\Contracts\MultiFieldDataManagerFactoryInterface;
use Backalley\Form\DataManagerFactory;
use Backalley\WordPress\Fields\Managers\PostTermManager;
use Backalley\WordPress\Fields\Managers\PostMetaFieldManager;
use Backalley\WordPress\Fields\Managers\TermMetaDataManager;

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
