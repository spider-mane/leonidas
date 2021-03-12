<?php

namespace Leonidas\Library\Admin\Metabox\Components;

use Psr\Http\Message\ServerRequestInterface;
use Leonidas\Contracts\Admin\Components\MetaboxComponentInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Metabox\Views\SectionView;
use Leonidas\Traits\CanBeRestrictedTrait;
use Leonidas\Traits\RendersWithViewTrait;

class Section implements MetaboxComponentInterface
{
    use CanBeRestrictedTrait;
    use RendersWithViewTrait;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var MetaboxComponentInterface[]
     */
    protected $components = [];

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
        return $this->components;
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
    public function addContent(string $slug, MetaboxComponentInterface $content)
    {
        $this->components[$slug] = $content;

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
    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        return new SectionView();
    }

    /**
     *
     */
    protected function defineViewContext(ServerRequestInterface $request): array
    {
        return [
            'padding' => $this->padding,
            'title' => $this->title,
            'is_fieldset' => $this->isFieldset,
            'components' => $this->components,
            'request' => $request
        ];
    }
}
