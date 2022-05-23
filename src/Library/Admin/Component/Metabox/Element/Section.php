<?php

namespace Leonidas\Library\Admin\Component\Metabox\Element;

use Leonidas\Contracts\Admin\Component\Metabox\MetaboxComponentInterface;
use Leonidas\Contracts\Ui\ViewInterface;
use Leonidas\Library\Admin\Abstracts\CanBeRestrictedTrait;
use Leonidas\Library\Admin\Abstracts\RendersWithViewTrait;
use Leonidas\Library\Admin\Component\Metabox\View\SectionView;
use Psr\Http\Message\ServerRequestInterface;

class Section implements MetaboxComponentInterface
{
    use CanBeRestrictedTrait;
    use RendersWithViewTrait;

    protected string $title;

    /**
     * @var MetaboxComponentInterface[]
     */
    protected array $components = [];

    protected int $padding = 2;

    protected bool $isFieldset = true;

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
     * @param array $content
     *
     * @return $this
     */
    public function setContent(array $content)
    {
        foreach ($content as $slug => $value) {
            $this->addContent($slug, $value);
        }

        return $this;
    }

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
     * @return $this
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
     * @return $this
     */
    public function setPadding(int $padding)
    {
        $this->padding = $padding;

        return $this;
    }

    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        return new SectionView();
    }

    protected function defineViewContext(ServerRequestInterface $request): array
    {
        return [
            'padding' => $this->padding,
            'title' => $this->title,
            'is_fieldset' => $this->isFieldset,
            'components' => $this->components,
            'request' => $request,
        ];
    }
}
