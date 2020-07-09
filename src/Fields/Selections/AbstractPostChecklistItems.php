<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Saveyour\Contracts\ChecklistItemsInterface;
use WebTheory\Saveyour\Fields\Selections\AbstractChecklistSelectionProvider;

abstract class AbstractPostChecklistItems extends AbstractChecklistSelectionProvider implements ChecklistItemsInterface
{
    /**
     * @var string
     */
    protected $idFormat = 'wts--post--%s';

    /**
     * Get the value of idFormat
     *
     * @return string
     */
    public function getIdFormat(): string
    {
        return $this->idFormat;
    }

    /**
     * Set the value of idFormat
     *
     * @param string $idFormat
     *
     * @return self
     */
    public function setIdFormat(string $idFormat)
    {
        $this->idFormat = $idFormat;

        return $this;
    }

    /**
     * @param WP_Post $post
     */
    protected function provideItemValue($post): string
    {
        return $post->ID;
    }

    /**
     * @param WP_Post $post
     */
    protected function provideItemLabel($post): string
    {
        return $post->post_title;
    }

    /**
     * @param WP_Post $post
     */
    protected function provideItemId($post): string
    {
        return sprintf($this->idFormat, $post->post_name);
    }
}
