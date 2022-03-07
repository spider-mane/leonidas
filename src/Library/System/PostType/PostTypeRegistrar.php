<?php

namespace Leonidas\Library\System\PostType;

use Leonidas\Contracts\System\PostType\PostTypeInterface;
use Leonidas\Contracts\System\PostType\PostTypeOptionHandlerCollectionInterface;
use Leonidas\Contracts\System\PostType\PostTypeRegistrarInterface;
use Leonidas\Library\System\AbstractSystemModelTypeRegistrar;

class PostTypeRegistrar extends AbstractSystemModelTypeRegistrar implements PostTypeRegistrarInterface
{
    protected ?PostTypeOptionHandlerCollectionInterface $optionHandlers = null;

    public function __construct(?PostTypeOptionHandlerCollectionInterface $optionHandlers = null)
    {
        $this->optionHandlers = $optionHandlers;
    }

    public function registerOne(PostTypeInterface $postType)
    {
        $registered = register_post_type(
            $postType->getName(),
            $this->getArgs($postType)
        );

        $registered->options = $postType->getOptions();

        if (isset($this->optionHandlers)) {
            $this->registerOptions($postType);
        }
    }

    public function registerMany(PostTypeInterface ...$postTypes)
    {
        foreach ($postTypes as $postType) {
            $this->registerOne($postType);
        }
    }

    protected function getArgs(PostTypeInterface $postType)
    {
        $args = [
            'exclude_from_search' => $postType->isExcludedFromSearch(),
            'show_in_admin_bar' => $postType->isShownInAdminBar(),
            'menu_position' => $postType->getMenuPosition(),
            'menu_icon' => $postType->getMenuIcon(),
            'capability_type' => $postType->getCapabilityType(),
            'map_meta_cap' => $postType->usesMapMetaCap(),
            'supports' => $postType->getSupports(),
            'register_meta_box_cb' => $postType->getRegisterMetaBoxCb(),
            'taxonomies' => $postType->getTaxonomies(),
            'has_archive' => $postType->getArchive(),
            'can_export' => $postType->canBeExported(),
            'delete_with_user' => $postType->isDeletedWithUser(),
            'template' => $postType->getTemplate(),
            'template_lock' => $postType->getTemplateLock(),
        ] + $this->getBaseArgs($postType);

        return array_filter($args, fn ($arg) => $arg !== null);
    }

    protected function registerOptions(PostTypeInterface $postType)
    {
        foreach ($postType->getOptions() as $option => $value) {
            if ($this->optionHandlers->has($option)) {
                $this->optionHandlers->get($option)->handle($postType, $value);
            }

            throw $this->unregisteredOptionException($option);
        }
    }
}
