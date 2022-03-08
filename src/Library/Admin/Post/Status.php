<?php

namespace Leonidas\Library\Admin\Post;

use WebTheory\Html\Html;

class Status
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var object
     */
    protected $args;

    public function __construct(string $name, $options = [])
    {
        $this->name = $name;
        $this->setOptions($options);
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of options
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Set the value of options
     *
     * @param array $options
     *
     * @return self
     */
    public function setOptions(array $options)
    {
        $this->options = $options + $this->getDefaultOptions();

        return $this;
    }

    /**
     * Get the value of args
     *
     * @return object
     */
    public function getArgs(): object
    {
        return $this->args;
    }

    public function editOption($option, $value)
    {
        $this->options[$option] = $value;
    }

    public function getOptionValue($option)
    {
        return $this->options[$option];
    }

    protected function getDefaultOptions(): array
    {
        $tag = Html::tag('span', ['class' => 'count'], '(%s)');
        $title = ucfirst($this->name);

        return [
            'label' => _x($title, 'post'),
            'public' => true,
            'exclude_from_search' => false,
            'show_in_admin_all_list' => true,
            'show_in_admin_status_list' => true,
            'post_type' => ['post', 'movie'],
            'publish_text' => __('Apply Changes'),
            'label_count' => _n_noop("{$title} {$tag}", "{$title} {$tag}"),
        ];
    }

    public function register()
    {
        $this->args = register_post_status($this->name, $this->options);

        return $this;
    }
}
