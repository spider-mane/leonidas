<?php

namespace Backalley\WordPress\MetaBox;

use Backalley\WordPress\MetaBox\Contracts\MetaboxContentInterface;
use Backalley\Html\Html;

class Section implements MetaboxContentInterface
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var array
     */
    protected $content;

    /**
     *
     */
    public function __construct($title)
    {
        $this->title = $title;
    }

    /**
     * Get the value of title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get the value of content
     *
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @param array  $content
     *
     * @return self
     */
    public function setContent(array $content)
    {
        foreach ($content as $slug => $value) {
            $this->addContent($slug, $value);
        }

        return $this;
    }

    /**
     * Set the value of content
     *
     * @param array  $content
     *
     * @return self
     */
    public function addContent(string $slug, MetaboxContentInterface $content)
    {
        $this->content[$slug] = $content;

        return $this;
    }

    /**
     *
     */
    public function render($post)
    {
        echo Html::open('fieldset') . Html::tag('h3', $this->title);

        foreach ($this->content as $content) {
            $content->render($post);
        }

        echo Html::close('fieldset');
    }
}
