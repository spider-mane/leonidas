<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Http\ConstrainerCollectionInterface;
use Leonidas\Contracts\Ui\Asset\InlineScriptInterface;
use Leonidas\Contracts\Ui\Asset\InlineStyleInterface;
use Leonidas\Contracts\Ui\Asset\StyleInterface;
use Leonidas\Library\Core\Asset\Traits\HasStyleDataTrait;

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
        ?bool $shouldBeEnqueued = null,
        ?ConstrainerCollectionInterface $constraints = null,
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
            $shouldBeEnqueued,
            $constraints,
            $attributes,
            $crossorigin
        );

        $media && $this->media = $media;
        $isDisabled && $this->isDisabled = $isDisabled;
        $hrefLang && $this->hrefLang = $hrefLang;
        $title && $this->title = $title;
    }
}
