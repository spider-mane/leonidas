<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\StyleInterface;
use Leonidas\Library\Core\Asset\Traits\HasStyleDataTrait;
use WebTheory\Html\Html;

class Style extends AbstractAsset implements StyleInterface
{
    use HasStyleDataTrait;

    /**
     * @var string
     */
    protected $media = 'all';

    /**
     * @var bool
     */
    protected $isDisabled;

    /**
     * @var string
     */
    protected $hrefLang;

    /**
     * @var string
     */
    protected $title;

    public function __construct(
        string $handle,
        string $src,
        ?array $dependencies = null,
        $version = null,
        ?string $media = null,
        ?array $globalConstraints = null,
        ?array $registrationConstraints = null,
        ?array $enqueueConstraints = null,
        ?array $attributes = null,
        ?string $crossorigin = null,
        ?bool $isDisabled = null,
        ?string $hrefLang = null,
        ?string $title = null
    ) {
        parent::__construct(
            $handle,
            $src,
            $dependencies,
            $version,
            $globalConstraints,
            $registrationConstraints,
            $enqueueConstraints,
            $attributes,
            $crossorigin
        );

        $media && $this->media = $media;
        $isDisabled && $this->isDisabled = $isDisabled;
        $hrefLang && $this->hrefLang = $hrefLang;
        $title && $this->title = $title;
    }

    public function toHtml(): string
    {
        return Html::tag('link', [
            'rel' => 'stylesheet',
            'id' => "{$this->getHandle()}-css",
            'href' => $this->getSrcAttribute(),
            'media' => $this->getMedia(),
            'crossorigin' => $this->getCrossorigin(),
            'disabled' => $this->isDisabled(),
            'hreflang' => $this->getHrefLang(),
            'title' => $this->getTitle()
        ] + $this->getAttributes()) . "\n";
    }
}
