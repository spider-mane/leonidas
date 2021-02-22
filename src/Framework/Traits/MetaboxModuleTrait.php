<?php

namespace WebTheory\Leonidas\Framework\Traits;

use WebTheory\Leonidas\Admin\Contracts\MetaboxComponentInterface;
use WebTheory\Leonidas\Admin\Metabox\Metabox;

trait MetaboxModuleTrait
{
    /**
     * @var Metabox
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
    public static function renderMetaBox($post, $data, Metabox $metabox)
    {
        foreach (static::composeMetabox() as $key => $component) {
            static::$metabox->addContent($key, $component);
        }

        static::$metabox->renderMetabox($post);
    }

    /**
     *
     */
    abstract protected static function createMetaBox(): Metabox;

    /**
     * @return MetaboxComponentInterface[]
     */
    abstract protected static function composeMetabox(): array;
}
