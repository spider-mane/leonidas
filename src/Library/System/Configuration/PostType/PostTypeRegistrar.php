<?php

namespace Leonidas\Library\System\Configuration\PostType;

use Leonidas\Contracts\System\Configuration\PostType\PostTypeInterface;
use Leonidas\Contracts\System\Configuration\PostType\PostTypeOptionHandlerCollectionInterface;
use Leonidas\Contracts\System\Configuration\PostType\PostTypeRegistrarInterface;
use Leonidas\Library\System\Configuration\Abstracts\AbstractModelConfigurationRegistrar;
use Leonidas\Library\System\Schema\Abstracts\ThrowsExceptionOnWpErrorTrait;

class PostTypeRegistrar extends AbstractModelConfigurationRegistrar implements PostTypeRegistrarInterface
{
    use ThrowsExceptionOnWpErrorTrait;

    protected ?PostTypeOptionHandlerCollectionInterface $optionHandlers = null;

    public function __construct(?PostTypeOptionHandlerCollectionInterface $optionHandlers = null)
    {
        $this->optionHandlers = $optionHandlers;
    }

    public function registerOne(PostTypeInterface $postType)
    {
        $this->throwExceptionIfWpError(
            $registered = register_post_type(
                $postType->getName(),
                $this->getArgs($postType)
            )
        );

        $registered->extra = $postType->getExtra();

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

    public function overrideOne(PostTypeInterface $postType)
    {
        global $wp_post_types;

        $registered = $wp_post_types[$postType->getName()];

        dd($registered);

        $registered->extra = $postType->getExtra();

        if (isset($this->optionHandlers)) {
            $this->registerOptions($postType);
        }
    }

    public function overrideMany(PostTypeInterface ...$postTypes)
    {
        foreach ($postTypes as $postType) {
            $this->overrideOne($postType);
        }
    }

    protected function getArgs(PostTypeInterface $postType)
    {
        $args = [
            // info
            'taxonomies' => $postType->getTaxonomies(),

            // core
            'capability_type' => $postType->getCapabilityType(),
            'delete_with_user' => $postType->isDeletedWithUser(),
            'can_export' => $postType->canBeExported(),
            'map_meta_cap' => $postType->allowsMetaCapMapping(),

            // web
            'has_archive' => $postType->getArchive(),
            'exclude_from_search' => $postType->isExcludedFromSearch(),

            // REST
            'autosave_rest_controller_class' => $postType->getAutosaveRestControllerClass(),
            'revisions_rest_controller_class' => $postType->getRevisionsRestControllerClass(),
            'late_route_registration' => $postType->allowsLateRouteRegistration(),

            // admin
            'show_in_menu' => $postType->getDisplayedInMenu(),
            'menu_position' => $postType->getMenuPosition(),
            'menu_icon' => $postType->getMenuIcon(),
            'show_in_admin_bar' => $postType->isAllowedInAdminBar(),
            'supports' => $postType->getSupports(),
            'register_meta_box_cb' => $postType->getRegisterMetaBoxCb(),
            'template' => $postType->getTemplate(),
            'template_lock' => $postType->getTemplateLock(),
        ] + $this->getBaseArgs($postType);

        return array_filter($args, fn ($arg) => $arg !== null);
    }

    protected function registerOptions(PostTypeInterface $postType)
    {
        foreach ($postType->getExtra() as $option => $value) {
            if ($this->optionHandlers->has($option)) {
                $this->optionHandlers->get($option)->handle($postType, $value);
            }

            throw $this->unregisteredOptionException($option);
        }
    }
}
