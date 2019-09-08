<?php

namespace Backalley\Wordpress\Fields\Managers;

use Backalley\Form\Contracts\MultiFieldDataManagerFactoryInterface;
use Backalley\Form\DataManagerFactory;
use Backalley\WordPress\Fields\Managers\PostTermManager;
use Backalley\WordPress\Fields\Managers\TermRelatedPostsManager;
use Backalley\Wordpress\Fields\Managers\PostMetaFieldManager;
use Backalley\Wordpress\Fields\Managers\TermBasedPostMeta;
use Backalley\Wordpress\Fields\Managers\TermMetaDataManager;

class Factory extends DataManagerFactory implements MultiFieldDataManagerFactoryInterface
{
    public const NAMESPACE = [__NAMESPACE__] + parent::NAMESPACE;

    public const MANAGERS = [
        'post_meta' => PostMetaFieldManager::class,
        'term_meta' => TermMetaDataManager::class,
        'post_term' => PostTermManager::class,
        'term_based_post_meta' => TermBasedPostMeta::class,
        'term_related_posts' => TermRelatedPostsManager::class,
    ] + parent::MANAGERS;
}
