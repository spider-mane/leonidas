<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Ui\Asset\ImageSizeInterface;

class ImageSize implements ImageSizeInterface
{
    protected string $name;

    protected string $label;

    protected int $width;

    protected int $height;

    /**
     * @var bool|array
     */
    protected $crop = false;

    public function __construct(string $name, string $label, int $width, int $height, $crop = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->width = $width;
        $this->height = $height;
        $this->crop = $crop;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * {@inheritDoc}
     */
    public function getCrop()
    {
        return $this->crop;
    }

    public static function create(array $definition): ImageSize
    {
        return static(
            $definition['name'],
            $definition['label'],
            $definition['width'],
            $definition['height'],
            $definition['crop'] ?? false
        );
    }
}
