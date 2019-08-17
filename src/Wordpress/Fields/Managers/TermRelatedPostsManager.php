<?php

namespace Backalley\WordPress\Fields\Managers;

use Backalley\Form\DataSchemes\IO;
use Backalley\Form\Managers\AbstractFieldDataManager;
use Backalley\Form\Contracts\FieldDataManagerInterface;

class TermRelatedPostsManager extends AbstractFieldDataManager implements FieldDataManagerInterface, IO
{
    /**
     * The taxonomy that shadows the relatable post type
     *
     * @var string $shadow
     */
    protected $shadow;

    /**
     * The related post type
     *
     * @var string $related
     */
    protected $related;

    /**
     * The relatable post type
     *
     * @var string $relatable
     */
    protected $relatable;

    /**
     * current_context
     *
     * @var string
     */
    private $context;

    /**
     * Whether or not the relationship should be enforced as a one to one
     * relationship
     *
     * @var bool
     */
    protected $oneToOne = false;

    /**
     *
     */
    public function __construct($shadow, $related, $relatable)
    {
        $this->shadow = $shadow;
        $this->related = $related;
        $this->relatable = $relatable;
    }

    /**
     * Get the value of shadow
     *
     * @return string
     */
    public function getShadow()
    {
        return $this->shadow;
    }

    /**
     * Get the value of related
     *
     * @return string
     */
    public function getRelated()
    {
        return $this->related;
    }

    /**
     * Get the value of relatable
     *
     * @return string
     */
    public function getRelatable()
    {
        return $this->relatable;
    }

    /**
     *
     */
    public function getData($post)
    {
        $this->setContext($post);

        if ('related' === $this->context) {
            $items = $this->getRelatedContextItems($post);
        } elseif ('relatable' === $this->context) {
            $items = $this->getRelatableContextItems($post);
        }

        return $items;
    }

    /**
     *
     */
    public function saveData($post, $data): bool
    {
        $this->setContext($post);

        if ('relatable' === $this->context) {
            $this->saveRelatableContext($post, $data);
        } elseif ('related' === $this->context) {
            $this->saveRelatedContext($post, $data);
        }

        return true;
    }

    /**
     *
     */
    private function setContext($post)
    {
        $this->context = $post->post_type === $this->related ? 'related' : 'relatable';
    }

    /**
     *
     */
    private function getRelatableContextItems($post)
    {
        $items = get_posts([
            'fields' => 'post_name',
            'post_type' => $this->related,
            'posts_per_page' => -1,
            'suppress_filters' => false,
            'tax_query' => [[
                'taxonomy' => $this->shadow,
                'terms' => (string) $post->ID,
                'field' => 'slug',
                'include_children' => false,
            ]]
        ]);

        foreach ($items as &$item) {
            $item = $item->post_name;
        }

        return $items;
    }

    /**
     *
     */
    private function getRelatedContextItems($post)
    {
        $items = get_terms([
            'taxonomy' => $this->shadow,
            'object_ids' => $post->ID,
            'hierarchical' => false,
        ]);

        foreach ($items as &$item) {
            $item = $item->slug;
        }

        return $items;
    }

    /**
     *
     */
    private function saveRelatableContext($relatablePost, $relatedPosts)
    {
        $relatablePost = (string) $relatablePost->ID;

        foreach ($relatedPosts as $relatedPost => $selected) {

            if ($selected) {

                /*
                 ! do not under any circunstances modify 4th argument ($append).
                 ! It must be set to true in order to prevent completely
                 ! rewriting terms of the related post.
                 */
                wp_set_object_terms((int) $relatedPost, $relatablePost, $this->shadow, true);
            } elseif (!$selected) {
                wp_remove_object_terms((int) $relatedPost, $relatablePost, $this->shadow);
            }
        }
    }

    /**
     *
     */
    private function saveRelatedContext($relatedPost, $relatablePosts)
    {
        wp_set_object_terms($relatedPost->ID, $relatablePosts, $this->shadow, false);
    }
}
