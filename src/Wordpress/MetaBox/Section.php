<?php

namespace Backalley\WordPress\MetaBox;

use Backalley\Html\Html;
use Backalley\WordPress\MetaBox\Contracts\MetaboxContentInterface;

class Section implements MetaboxContentInterface
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var array
     */
    protected $content = [];

    /**
     * @var int
     */
    protected $padding = 2;

    /**
     * @var bool
     */
    protected $isFieldset = true;

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
     * Get the value of isFieldset
     *
     * @return bool
     */
    public function isFieldset(): bool
    {
        return $this->isFieldset;
    }

    /**
     * Set the value of isFieldset
     *
     * @param bool $isFieldset
     *
     * @return self
     */
    public function setIsFieldset(bool $isFieldset)
    {
        $this->isFieldset = $isFieldset;

        return $this;
    }

    /**
     * Get the value of padding
     *
     * @return int
     */
    public function getPadding(): int
    {
        return $this->padding;
    }

    /**
     * Set the value of padding
     *
     * @param int $padding
     *
     * @return self
     */
    public function setPadding(int $padding)
    {
        $this->padding = $padding;

        return $this;
    }

    /**
     *
     */
    public function render($post)
    {
        $html = '';

        $titleElement = Html::tag('h3', $this->title);
        $attributes = ['class' => "py-{$this->padding}"];
        $container = $this->isFieldset ? 'fieldset' : 'div';

        $html .= Html::open($container, $attributes);

        if ($this->isFieldset && false) {
            // temporarily disabled because legend elements are absolutely
            // positioned within their container, making padding not work
            // as desired
            $html .= Html::tag('legend', $titleElement);
        } else {
            $html .= $titleElement;
        }

        foreach ($this->content as $content) {
            $html .= $content->render($post);
        }

        $html .= Html::close($container);

        return $html;
    }
}