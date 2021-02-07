<?php

namespace WebTheory\Leonidas\Framework\Traits;

use WebTheory\Leonidas\Admin\Metabox\Contracts\MetaboxContentInterface;
use WebTheory\Leonidas\Admin\Metabox\MetaBox;

trait MetaboxModuleTrait
{
    /**
     * @var MetaBox
     */
    protected static $metabox;

    /**
     *
     */
    public static function hook()
    {
        static::addMetabox();
    }

    /**
     *
     */
    protected static function addMetabox()
    {
        static::$metabox = static::createMetaBox();
        $screen = static::$metabox->getScreen();

        add_action("add_metabox_{$screen}", [static::class, 'registerMetabox'], null, PHP_INT_MAX);
    }

    /**
     *
     */
    public static function registerMetabox()
    {
        static::$metabox
            ->setCallback([static::class, 'renderMetaBox'])
            ->register();
    }

    /**
     *
     */
    public static function renderMetaBox($post, $data, MetaBox $metabox)
    {
        foreach (static::composeMetabox() as $key => $component) {
            static::$metabox->addContent($key, $component);
        }

        static::$metabox->render($post);
    }

    /**
     *
     */
    abstract protected static function createMetaBox(): MetaBox;

    /**
     * @return MetaboxContentInterface[]
     */
    abstract protected static function composeMetabox(): array;
}
