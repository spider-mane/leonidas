<?php

namespace Leonidas\Library\Admin\Field\Selection\Abstracts;

use WP_Post;

trait PostChecklistItemsTrait
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
     * @return $this
     */
    public function setIdFormat(string $idFormat)
    {
        $this->idFormat = $idFormat;

        return $this;
    }

    /**
     * @param WP_Post $post
     */
    public function defineSelectionLabel($post): string
    {
        return $post->post_title;
    }

    /**
     * @param WP_Post $post
     */
    public function defineSelectionId($post): string
    {
        return sprintf($this->idFormat, $post->post_name);
    }
}
