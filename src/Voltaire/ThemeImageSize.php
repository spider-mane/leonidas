<?php

namespace WebTheory\Voltaire;

class ThemeImageSize
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var bool
     */
    protected $crop;

    /**
     *
     */
    public function __construct(string $name, int $width, int $height)
    {
        $this->name = $name;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Get the value of label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the value of label
     *
     * @param string $label
     *
     * @return self
     */
    public function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the value of crop
     *
     * @return bool
     */
    public function getCrop(): bool
    {
        return $this->crop;
    }

    /**
     * Set the value of crop
     *
     * @param bool $crop
     *
     * @return self
     */
    public function setCrop(bool $crop)
    {
        $this->crop = $crop;

        return $this;
    }

    /**
     *
     */
    public function hook()
    {
        if (isset($this->label)) {
            add_filter('image_size_names_choose', [$this, 'defineSizeLabel']);
        }

        return $this;
    }

    /**
     *
     */
    protected function register()
    {
        add_image_size($this->name, $this->width, $this->height, $this->crop);

        return $this;
    }

    /**
     *
     */
    public function defineSizeLabel($names)
    {
        $names[$this->name] = $this->label;

        return $names;
    }

    /**
     *
     */
    public static function create(array $sizes)
    {
        foreach ($sizes as $name => $attr) {

            $crop = $attr['crop'] ?? null;
            $label = $attr['label'] ?? null;

            $size = (new static($name, $attr['width'], $attr['height']));

            if (isset($crop)) {
                $size->setCrop($crop);
            }

            if (isset($label)) {
                $size->setLabel($label);
            }

            $size->register()->hook();
        }
    }
}
